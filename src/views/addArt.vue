<template>
  <v-row justify="center">
		<v-col cols="12">

			<v-card-actions class="pa-0">
				<strong class="">Agregar Articulo</strong>
				<v-spacer></v-spacer>
				<v-btn color="red darken-4" text @click="$emit('modal',false)">
					<v-icon>clear</v-icon>
				</v-btn>
			</v-card-actions>

			<v-divider></v-divider>

			<v-card-text>
				<v-container>
					<v-row >
						<v-col cols="12" sm="6" md="4">
							<v-text-field label="Nombre del articulo" 
								v-model="nombre" 
								hide-details
								clearable
							></v-text-field>
						</v-col>
						<v-col cols="12" sm="6" md="4">
							<v-text-field label="Talla" 
								v-model="talla" 
								hide-details
								clearable
							></v-text-field>
						</v-col>

						<v-col cols="12" sm="6" md="4">
							<v-text-field
								label="Costo"
								persistent-hint
								type="number"
								v-model="costo"
								hiden-details
								clearable
							></v-text-field>
						</v-col>

						<v-col cols="12" sm="6">
							<v-select
								:items="['Dama','Caballero']"
								label="Genero"
								v-model="genero"
								hiden-details
							></v-select>
						</v-col>
						
						<v-col cols="12" sm="6">
							<v-select
								:items="['Pantalon','Camisetas','Calzado']"
								label="Tipo de articulo"
								v-model="tipo"
								hiden-details
							></v-select>
						</v-col>
						<v-col cols="12" v-show="tipo && genero">
							<v-file-input
								v-model="files"
								multiple
								outlined
								dense
								:rules="rules"
								:ref="`pictureInput`"
								accept="image/png, image/jpeg, image/bmp"
								placeholder="Cargarimagenes"
								append-icon="mdi-camera"
								@change="cargar()"
								multiple
								hiden-details
							></v-file-input>
							<v-card-text>
                <v-row>
                  <v-col cols="12"   v-for="(img, i) in imagenesPrevias" :key="i">
                    <v-card flat>
                      <v-img
                        :src="img.url2"
                        class="white--text align-end"
                        width="100%"
                        height="150px"
												aspect-ratio="1" contain
                      >
                      </v-img>
                    </v-card>
                  </v-col>
                </v-row>
              </v-card-text>

							<v-card-actions class="pa-0">
							<v-spacer></v-spacer>
							<v-btn color="green darken-4" dark @click="grabar()">Guardar</v-btn>
						</v-card-actions>
						</v-col>
					
					</v-row>
				</v-container>
			</v-card-text>
		</v-col>
  </v-row>
</template>

<script>
  import {mapGetters, mapActions} from 'vuex'

export default {
	data: () => ({
		rules: [
      value => !value || value.size < 2000000 || 'Máximo 2 MB!',
      ],
		files: [],
		imagen1:'',
		Url:'',
		imagenesPrevias:[],
		nombre:'',
		costo:'',
		talla:'',
		genero:'',
		tipo: '',
		CargarImagen: false,
		rute: ''

	}),


	methods:{
    ...mapActions('Actualizador',['consultarArticulos']),

		grabar(){
			
			var payload = {
				nombre: this.nombre,
				talla: this.talla,
				genero: this.genero.toLowerCase(),
				costo: this.costo,
				tipo: this.tipo.toLowerCase(),
				foto: '/'+ this.rute + this.imagenesPrevias[0].imagen_name
			}

			this.$http.post('articulos.add', payload).then(response=>{
				console.log("response", response)
			}).catch(error=>{
				console.log("error", error)
			})


			this.$http.post('documentos', this.imagenesPrevias[0].formData, this.rute).then(response=>{
				console.log("response", response)
				this.consultarArticulos();
				this.$emit('modal',false)

			}).catch(error=>{
				console.log("error", error)
			})
		},

		cargar(){
			//  si la variable esta vacia no carga nada y regresamos la función
			if(this.files == null ){
				return
			}

			this.files.forEach((element, index) => {
				// creamos una variable tipo FormData
				let formData = new FormData();
				//se crea el objeto y se le agrega como un apendice el archivo 
				formData.append('file', element);
				//mandamos a ocvertir la imagen a base64 pero mandamos el docuemnto, el formdata, el nombre
				var url = this.$http.options.root.replace("api2/public/", "public/"); // dame un minuto 

				console.log('url', url);
				this.getBase64(element, formData, element.name, this.numart, url + element.name)
			})
		},

		getBase64(file, formData, name, numart, url) {
			var me = this
			//Se crea un avariable para lectura de archivo
			var reader = new FileReader();
			// obtiene el url del archivo para ser visualizado
			reader.readAsDataURL(file);
			reader.onload = function () {
				// se crea el objeto con los parametros
				// el id es la ongitu del objeto
				//  el url es el resultado de convertir el archivo a base64 url
				//  el formdata, el parametro que recibira la api
				// el nombre, para guardar en la base de datos
				me.imagenesPrevias.push({id: me.imagenesPrevias.length, 
																 url: url, 
																 url2: reader.result, 
																 formData: formData, 
																 imagen_name: name, 
																 numart:numart, 
																 image_name: name,
															 })
				// me.$refs.pictureInput.internalValue = null
			};
			console.log('previas',me.imagenesPrevias)//okeyyy
		},

		updateImgMas(){
			// Recorremos las imagenes previas cargadas para poder agregarlas al servidor y guardar el nombre en la base de datos
			this.imagenesPrevias.forEach((element, index) => {
				// Mandamos el formdata (archivo de la imagen) al servidor
				this.$http.post('documentos', element.formData).then(response=>{
					if(index == 0){
						this.text = 'Fotos cargadas exitosamente'
						this.snackbar =  false
						
						// Mandas a traer las imagenes del servidor
						this.grabarFotosxArt()

						// Limpiamos las imagenes previas ya cuando se haya terminado el recorrido del foreach
						this.imagenesPrevias = []
					}
				})
			})
		},

		grabarFotosxArt(){
			this.loading = true 
			let cnumart = this.numart.trim()
			var payload = this.imagenesPrevias

			this.imagenesPrevias.forEach((element, index) => {
				this.$http.post('v1/product.image.add', element).then(response => {
					console.log('Fotos x numart',response.body)
					this.cargarFotos()
				}).catch(error =>{
					console.log(error)
				}).finally(()  => this.loading = false )

			})
		}
	}
}
</script>
