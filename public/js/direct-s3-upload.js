/**
 * Script para manejar subida directa de archivos grandes a S3
 * Evita los límites de PHP para archivos grandes
 */

class DirectS3Upload {
    constructor(options = {}) {
        this.baseUrl = options.baseUrl || '';
        this.csrfToken = options.csrfToken || document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        this.progressCallback = options.progressCallback || null;
        this.successCallback = options.successCallback || null;
        this.errorCallback = options.errorCallback || null;
    }

    /**
     * Subir archivo directamente a S3
     */
    async uploadFile(file, gazetteData) {
        try {
            // Paso 1: Obtener URL prefirmada
            const presignedData = await this.getPresignedUrl(file, gazetteData);
            
            // Paso 2: Subir archivo directamente a S3
            await this.uploadToS3(file, presignedData.presigned_url);
            
            // Paso 3: Confirmar que se subió correctamente
            const result = await this.confirmUpload(gazetteData.gazette_id, {
                filepath: presignedData.filepath,
                filename: presignedData.filename,
                filesize: file.size,
                file_extension: this.getFileExtension(file.name)
            });
            
            if (this.successCallback) {
                this.successCallback(result);
            }
            
            return result;
            
        } catch (error) {
            if (this.errorCallback) {
                this.errorCallback(error);
            }
            throw error;
        }
    }

    /**
     * Obtener URL prefirmada del servidor
     */
    async getPresignedUrl(file, gazetteData) {
        const response = await fetch(`${this.baseUrl}/gazettes/generate-presigned-url`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': this.csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                filename: file.name,
                content_type: file.type,
                gazette_name: gazetteData.name,
                document_number: gazetteData.document_number
            })
        });

        if (!response.ok) {
            throw new Error('Error al generar URL prefirmada');
        }

        return await response.json();
    }

    /**
     * Subir archivo directamente a S3
     */
    async uploadToS3(file, presignedUrl) {
        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            
            // Callback de progreso
            if (this.progressCallback) {
                xhr.upload.addEventListener('progress', (e) => {
                    if (e.lengthComputable) {
                        const percentComplete = (e.loaded / e.total) * 100;
                        this.progressCallback(percentComplete);
                    }
                });
            }
            
            xhr.addEventListener('load', () => {
                if (xhr.status === 200) {
                    resolve();
                } else {
                    reject(new Error('Error al subir archivo a S3'));
                }
            });
            
            xhr.addEventListener('error', () => {
                reject(new Error('Error de red al subir archivo'));
            });
            
            xhr.open('PUT', presignedUrl);
            xhr.setRequestHeader('Content-Type', file.type);
            xhr.send(file);
        });
    }

    /**
     * Confirmar subida en el servidor
     */
    async confirmUpload(gazetteId, fileData) {
        const response = await fetch(`${this.baseUrl}/gazettes/confirm-direct-upload`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': this.csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                gazette_id: gazetteId,
                ...fileData
            })
        });

        if (!response.ok) {
            throw new Error('Error al confirmar subida');
        }

        return await response.json();
    }

    /**
     * Obtener extensión del archivo
     */
    getFileExtension(filename) {
        return filename.split('.').pop().toLowerCase();
    }
}

// Ejemplo de uso:
/*
document.getElementById('file-input').addEventListener('change', async function(e) {
    const file = e.target.files[0];
    if (!file) return;

    const uploader = new DirectS3Upload({
        baseUrl: '', // URL base de tu aplicación
        progressCallback: (percent) => {
            console.log(`Progreso: ${percent.toFixed(2)}%`);
            // Actualizar barra de progreso
        },
        successCallback: (result) => {
            console.log('Archivo subido exitosamente:', result);
            // Mostrar mensaje de éxito
        },
        errorCallback: (error) => {
            console.error('Error al subir archivo:', error);
            // Mostrar mensaje de error
        }
    });

    const gazetteData = {
        gazette_id: 1, // ID de la gaceta existente
        name: 'Nombre de la gaceta',
        document_number: '123'
    };

    try {
        await uploader.uploadFile(file, gazetteData);
    } catch (error) {
        console.error('Error:', error);
    }
});
*/
