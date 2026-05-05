import 'dart:convert';

import 'package:flutter/material.dart';
import 'package:flutter/services.dart' show rootBundle;
import 'package:flutter_map/flutter_map.dart';
import 'package:latlong2/latlong.dart';

class HomeScreen extends StatefulWidget {
  const HomeScreen({super.key});

  @override
  State<HomeScreen> createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  late final Future<_GeoData> _geoDataFuture;

  @override
  void initState() {
    super.initState();
    _geoDataFuture = _loadGeoData();
  }

  Future<_GeoData> _loadGeoData() async {
    final raw = await rootBundle.loadString('assets/images/geojson/colcapirhua.geojson');
    final jsonData = jsonDecode(raw) as Map<String, dynamic>;

    final polygons = <Polygon>[];
    final polylines = <Polyline>[];
    final allPoints = <LatLng>[];

    final features = jsonData['features'] as List<dynamic>? ?? const [];
    for (final feature in features) {
      final geometry = (feature as Map<String, dynamic>)['geometry'] as Map<String, dynamic>?;
      if (geometry == null) continue;

      final type = geometry['type'] as String?;
      final coordinates = geometry['coordinates'];
      if (type == null || coordinates == null) continue;

      switch (type) {
        case 'Polygon':
          final rings = coordinates as List<dynamic>;
          if (rings.isEmpty) continue;
          final outer = _toLatLngList(rings.first);
          if (outer.isEmpty) continue;
          allPoints.addAll(outer);
          polygons.add(
            Polygon(
              points: outer,
              color: Colors.blue.withOpacity(0.2),
              borderColor: Colors.blue,
              borderStrokeWidth: 2,
            ),
          );
          break;
        case 'MultiPolygon':
          final multi = coordinates as List<dynamic>;
          for (final polygonData in multi) {
            final rings = polygonData as List<dynamic>;
            if (rings.isEmpty) continue;
            final outer = _toLatLngList(rings.first);
            if (outer.isEmpty) continue;
            allPoints.addAll(outer);
            polygons.add(
              Polygon(
                points: outer,
                color: Colors.blue.withOpacity(0.2),
                borderColor: Colors.blue,
                borderStrokeWidth: 2,
              ),
            );
          }
          break;
        case 'LineString':
          final points = _toLatLngList(coordinates);
          if (points.isEmpty) continue;
          allPoints.addAll(points);
          polylines.add(
            Polyline(
              points: points,
              color: Colors.red,
              strokeWidth: 3,
            ),
          );
          break;
        case 'MultiLineString':
          final lines = coordinates as List<dynamic>;
          for (final line in lines) {
            final points = _toLatLngList(line);
            if (points.isEmpty) continue;
            allPoints.addAll(points);
            polylines.add(
              Polyline(
                points: points,
                color: Colors.red,
                strokeWidth: 3,
              ),
            );
          }
          break;
      }
    }

    if (allPoints.isEmpty) {
      throw Exception('El archivo GeoJSON no contiene geometrías válidas.');
    }

    return _GeoData(
      polygons: polygons,
      polylines: polylines,
      center: allPoints.first,
    );
  }

  List<LatLng> _toLatLngList(dynamic coordinates) {
    final result = <LatLng>[];
    for (final point in coordinates as List<dynamic>) {
      if (point is! List || point.length < 2) continue;
      final lon = (point[0] as num?)?.toDouble();
      final lat = (point[1] as num?)?.toDouble();
      if (lat == null || lon == null) continue;
      result.add(LatLng(lat, lon));
    }
    return result;
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: FutureBuilder<_GeoData>(
        future: _geoDataFuture,
        builder: (context, snapshot) {
          if (snapshot.connectionState != ConnectionState.done) {
            return const Center(child: CircularProgressIndicator());
          }

          if (snapshot.hasError) {
            return Center(
              child: Text('Error al cargar GeoJSON: ${snapshot.error}'),
            );
          }

          final geoData = snapshot.data!;
          return FlutterMap(
            options: MapOptions(
              initialCenter: geoData.center,
              initialZoom: 13,
            ),
            children: [
              TileLayer(
                urlTemplate: 'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
                userAgentPackageName: 'com.colcatrufis.app',
              ),
              PolygonLayer(polygons: geoData.polygons),
              PolylineLayer(polylines: geoData.polylines),
            ],
          );
        },
      ),
    );
  }
}

class _GeoData {
  const _GeoData({
    required this.polygons,
    required this.polylines,
    required this.center,
  });

  final List<Polygon> polygons;
  final List<Polyline> polylines;
  final LatLng center;
}
