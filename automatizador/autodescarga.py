import os
import requests
import zipfile
import shutil
import subprocess
import webbrowser

from dotenv import load_dotenv
from pathlib import Path

load_dotenv()

def limpiarSFS(directorio):
	p = os.path.join(directorio, "pasado")
	os.makedirs(p, exist_ok=True)
	for i in os.listdir(directorio):
		if i != "pasado":
			shutil.move(os.path.join(directorio, i), os.path.join(p, i))

def facturar(base, directorio):
	
	urlArchivos = base + 'php/listarComprobantesRestantesSUNAT.php'
	urlLimpiar = base+ 'php/limpiarServidorSunat.php'
	urlArchivosFac = base + 'php/crearArchivosFacturacion.php'
	directorioData = directorio + r'sunat_archivos\sfs\DATA'
	accesoDirecto = directorio + r'EjecutarSFS.bat'
	accesoNavegador = directorio + r'abrirBandeja.bat'

	#limpiamos servidor:
	requests.get(urlLimpiar)

	limpiarSFS( directorioData )

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
						#eliminarArchivoZip
						archivoZip.unlink()
						#llamar al SFS
						token = os.getenv('token')
						os.startfile(accesoNavegador)
						webbrowser.open(base + f'php/accesoFast.php?token={token}')
						subprocess.run(['cmd', '/k', accesoDirecto], cwd=directorio, creationflags=subprocess.CREATE_NEW_CONSOLE)
				else:
					print(f"Error al descargar. Código: {responseZip.status_code}")
		else:
			print('No se encontró página  '+responseDocumentos.text)
		if( len(comprobantes) > 0):
			pass
		pass

#facturar('http://localhost/pluginSunat/', r'E:\SFS_v2.1\\')
#facturar('http://apps.infocatsoluciones.com/excelentemente/sancarlos/', r'E:\SFS_EXCEL\sancarlos\')
#facturar('http://apps.infocatsoluciones.com/excelentemente/eltambo/', r'E:\SFS_EXCEL\eltambo\')
