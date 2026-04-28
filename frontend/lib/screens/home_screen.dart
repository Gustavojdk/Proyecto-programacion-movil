// En lib/main.dart, antes de MyApp, agrega:
class HomeScreen extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text('Home')),
      body: Center(child: Text('Pantalla de Inicio')),
    );
  }
}