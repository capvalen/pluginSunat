import sys
from autodescarga import facturar

if __name__ == "__main__":
    # Verificar que se recibieron exactamente 2 parámetros
    if len(sys.argv) != 3:
        print("🚩 Uso incorrecto")
        print('🚩 Ejemplo de ejecución: py automatizacion.py http://localhost/pluginSunat/ "E:\\SFS_v2.1\\"')
        sys.exit(1)  # Salir con código de error
    
    # Capturar los parámetros
    base = sys.argv[1]
    directorio = sys.argv[2]
    
    # Llamar a la función facturar
    facturar(base, directorio)