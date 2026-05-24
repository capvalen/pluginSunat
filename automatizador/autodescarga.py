import os
import requests
import zipfile
from pathlib import Path

base = 'http://localhost/pluginSunat/'
urlArchivos = base + 'php/listarComprobantesRestantesSUNAT.php'
urlLimpiar = base+ 'php/limpiarServidorSunat.php'
urlArchivosFac = base + 'php/crearArchivosFacturacion.php'
directorio = './'
directorioData = directorio + 'DATA/'
accesoDirecto = directorio+'.lnk' #cambiar
#limpiamos servidor:
requests.get(urlLimpiar)

#pedimos los archivos
response = requests.get(urlArchivos)

if(response.status_code == 200): #si es ok	
	comprobantes = response.json()
	lista = []

	for comprobante in comprobantes:
		lista.append(comprobante['idComprobante'])
	
	#pedimos que genere los documentos:
	responseDocumentos = requests.post(urlArchivosFac, json={'comprobantes': lista})

	if(responseDocumentos.status_code == 200): #si es ok
		dataJson = responseDocumentos.json()
		if(dataJson[0] == 'Archivo Zip creado'):
			nombreArchivo = dataJson[1]+'.zip'
			urlZip = base+f'comprobantes/datosSunat_{nombreArchivo}'
			responseZip = requests.get(urlZip, stream=True) #true es para que no cargue en memoria
			if(responseZip.status_code == 200): #si cargo bien
				with open(nombreArchivo, 'wb') as archivo:
					for chunk in responseZip.iter_content(chunk_size=8192):
						if chunk:
							archivo.write(chunk)
				print(f"¡Archivo descargado exitosamente en {os.path.abspath(nombreArchivo)}!")
				with zipfile.ZipFile(nombreArchivo, 'r') as zip_ref:
					zip_ref.extractall(directorioData)
				
				archivoZip=Path(nombreArchivo)
				if archivoZip.exists():
					archivoZip.unlink()
				
				#llamar al SFS
				""" if os.path.exists(ruta_acceso_directo):
					os.startfile(ruta_acceso_directo) """

			else:
				print(f"Error al descargar. Código: {responseZip.status_code}")	
	else:
		print('No se encontró página  '+responseDocumentos.text)
	if( len(comprobantes) > 0):
		pass
	pass
