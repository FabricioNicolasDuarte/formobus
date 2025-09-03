<?php

require_once __DIR__ . '/Database.php';

/**
 * Esta clase representa el mapa de transporte de la ciudad como un grafo.
 * Las paradas son los nodos y las rutas de colectivo entre ellas son las aristas.
 */
class Mapa {
    private $conn;
    private $grafo; // Representaremos el grafo con una lista de adyacencia.

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
        $this->construirGrafo();
    }

    /**
     * Representación de Grafos (Lista de Adyacencia).
     * Carga todas las conexiones (aristas) desde la base de datos y construye el grafo.
     * El grafo será un array asociativo: [id_parada => [id_parada_adyacente1, id_parada_adyacente2, ...]]
     */
    private function construirGrafo() {
        $this->grafo = [];
        $query = "
            SELECT t1.parada_id AS origen, t2.parada_id AS destino, t1.linea_id
            FROM linea_parada t1
            JOIN linea_parada t2 ON t1.linea_id = t2.linea_id AND t1.orden = t2.orden - 1
        ";
        $stmt = $this->conn->query($query);
        $conexiones = $stmt->fetchAll();

        foreach ($conexiones as $conexion) {
            $origen = $conexion['origen'];
            $destino = $conexion['destino'];
            // Inicializamos si no existen
            if (!isset($this->grafo[$origen])) $this->grafo[$origen] = [];
            if (!isset($this->grafo[$destino])) $this->grafo[$destino] = [];

            // Añadimos la arista. Guardamos el destino y la línea que los conecta.
            $this->grafo[$origen][] = ['parada' => $destino, 'linea' => $conexion['linea_id']];
            // Si las líneas son de ida y vuelta, deberíamos añadir también la arista inversa.
            // Por simplicidad, asumimos recorridos de un solo sentido.
        }
    }
    
    /**
     * Algoritmo de Búsqueda en Anchura (BFS) para encontrar la ruta más corta.
     * @param int $inicio ID de la parada de origen.
     * @param int $fin ID de la parada de destino.
     * @return array|null La ruta encontrada o null si no existe.
     */
    public function encontrarRuta($inicio, $fin) {
        if (!isset($this->grafo[$inicio]) || !isset($this->grafo[$fin])) {
            return null; // Origen o destino no existen en el grafo.
        }

        // Usamos una cola para gestionar los nodos a visitar.
        $cola = new SplQueue();
        $cola->enqueue([$inicio]); // La cola guarda caminos, empezamos con el camino que solo tiene el inicio.

        $visitados = [$inicio]; // Para no entrar en ciclos infinitos.

        while (!$cola->isEmpty()) {
            $camino = $cola->dequeue();
            $ultimoNodo = end($camino);

            // Si  llegamos al destino, devolvemos el camino.
            if ($ultimoNodo == $fin) {
                return $this->detallarRuta($camino);
            }

            // Exploramos los vecinos (paradas adyacentes).
            if (isset($this->grafo[$ultimoNodo])) {
                foreach ($this->grafo[$ultimoNodo] as $vecinoInfo) {
                    $vecino = $vecinoInfo['parada'];
                    if (!in_array($vecino, $visitados)) {
                        $visitados[] = $vecino;
                        $nuevoCamino = $camino;
                        $nuevoCamino[] = $vecino;
                        $cola->enqueue($nuevoCamino);
                    }
                }
            }
        }

        return null; // No se encontró ruta.
    }

    /**
     * Convierte una lista de IDs de parada en una ruta detallada con nombres de parada y líneas.
     * @param array $caminoIDs Lista de IDs de paradas.
     * @return array Ruta detallada.
     */
    private function detallarRuta($caminoIDs) {
        $rutaDetallada = [];
        for ($i = 0; $i < count($caminoIDs) - 1; $i++) {
            $origenID = $caminoIDs[$i];
            $destinoID = $caminoIDs[$i+1];

            // Encontrar la línea que conecta este tramo
            $lineaID = null;
            foreach ($this->grafo[$origenID] as $conexion) {
                if ($conexion['parada'] == $destinoID) {
                    $lineaID = $conexion['linea'];
                    break;
                }
            }
            
            $paradaOrigen = Parada::find($origenID);
            $paradaDestino = Parada::find($destinoID);
            $linea = Linea::find($lineaID);

            $rutaDetallada[] = [
                'origen' => $paradaOrigen,
                'destino' => $paradaDestino,
                'linea' => $linea
            ];
        }
        return $rutaDetallada;
    }
}
