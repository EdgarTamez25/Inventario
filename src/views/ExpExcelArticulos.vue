<!-- BOTON PARA IMPRIMIR -->
<template>
	<v-layout row wrap>
	  <v-flex xs12>
	  	<v-btn  color="grey lighten-4" dark class="mb-2"  @click="handleDownload" ><div class="icons8-microsoft-excel"></div></v-btn>
	  </v-flex>
	</v-layout>
</template>        

<script>
  import {mapGetters} from 'vuex'
  require('script-loader!file-saver');
  import XLSX from 'xlsx'

  export default {
    
    computed:{
      ...mapGetters('Actualizador' ,['getArticulos']),
    },

    methods: {

      handleDownload() {
      // this.downloadLoading = true
      import('@/components/Export2Excel').then(excel => {
       
        const tHeader = ['Codigo','Nombre', 'Talla', 'Costo', 'Foto', 'Tipo de articulo', 'Genero']
        const filterVal = ['id', 'nombre', 'talla', 'costo','foto','tipo','genero']
        const list = this.getArticulos
        const data = this.formatJson(filterVal, list)

        excel.export_json_to_excel({
          header: tHeader,
          data,
          filename: 'Inventario Actual',
          autoWidth: true,
          bookType: 'xls'
        })
        this.downloadLoading = false
      })
    },

    formatJson(filterVal, jsonData) {
      return jsonData.map(v => filterVal.map(j => {
        if (j === 'timestamp') {
          return parseTime(v[j])
        } else {
          return v[j]
        }
      }))
    }

    }
  };
</script>

<style>
	.icons8-microsoft-excel { 
	display: inline-block;
	width: 30px;
	height: 30px;
	background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHg9IjBweCIgeT0iMHB4Igp3aWR0aD0iNDgiIGhlaWdodD0iNDgiCnZpZXdCb3g9IjAgMCA0OCA0OCIKc3R5bGU9IiBmaWxsOiMwMDAwMDA7Ij48ZyBpZD0ic3VyZmFjZTEiPjxwYXRoIHN0eWxlPSIgZmlsbDojNENBRjUwOyIgZD0iTSA0MSAxMCBMIDI1IDEwIEwgMjUgMzggTCA0MSAzOCBDIDQxLjU1NDY4OCAzOCA0MiAzNy41NTQ2ODggNDIgMzcgTCA0MiAxMSBDIDQyIDEwLjQ0NTMxMyA0MS41NTQ2ODggMTAgNDEgMTAgWiAiPjwvcGF0aD48cGF0aCBzdHlsZT0iIGZpbGw6I0ZGRkZGRjsiIGQ9Ik0gMzIgMTUgTCAzOSAxNSBMIDM5IDE4IEwgMzIgMTggWiAiPjwvcGF0aD48cGF0aCBzdHlsZT0iIGZpbGw6I0ZGRkZGRjsiIGQ9Ik0gMzIgMjUgTCAzOSAyNSBMIDM5IDI4IEwgMzIgMjggWiAiPjwvcGF0aD48cGF0aCBzdHlsZT0iIGZpbGw6I0ZGRkZGRjsiIGQ9Ik0gMzIgMzAgTCAzOSAzMCBMIDM5IDMzIEwgMzIgMzMgWiAiPjwvcGF0aD48cGF0aCBzdHlsZT0iIGZpbGw6I0ZGRkZGRjsiIGQ9Ik0gMzIgMjAgTCAzOSAyMCBMIDM5IDIzIEwgMzIgMjMgWiAiPjwvcGF0aD48cGF0aCBzdHlsZT0iIGZpbGw6I0ZGRkZGRjsiIGQ9Ik0gMjUgMTUgTCAzMCAxNSBMIDMwIDE4IEwgMjUgMTggWiAiPjwvcGF0aD48cGF0aCBzdHlsZT0iIGZpbGw6I0ZGRkZGRjsiIGQ9Ik0gMjUgMjUgTCAzMCAyNSBMIDMwIDI4IEwgMjUgMjggWiAiPjwvcGF0aD48cGF0aCBzdHlsZT0iIGZpbGw6I0ZGRkZGRjsiIGQ9Ik0gMjUgMzAgTCAzMCAzMCBMIDMwIDMzIEwgMjUgMzMgWiAiPjwvcGF0aD48cGF0aCBzdHlsZT0iIGZpbGw6I0ZGRkZGRjsiIGQ9Ik0gMjUgMjAgTCAzMCAyMCBMIDMwIDIzIEwgMjUgMjMgWiAiPjwvcGF0aD48cGF0aCBzdHlsZT0iIGZpbGw6IzJFN0QzMjsiIGQ9Ik0gMjcgNDIgTCA2IDM4IEwgNiAxMCBMIDI3IDYgWiAiPjwvcGF0aD48cGF0aCBzdHlsZT0iIGZpbGw6I0ZGRkZGRjsiIGQ9Ik0gMTkuMTI4OTA2IDMxIEwgMTYuNzE4NzUgMjYuNDM3NSBDIDE2LjYyNSAyNi4yNjk1MzEgMTYuNTMxMjUgMjUuOTU3MDMxIDE2LjQzMzU5NCAyNS41IEwgMTYuMzk4NDM4IDI1LjUgQyAxNi4zNTE1NjMgMjUuNzE0ODQ0IDE2LjI0MjE4OCAyNi4wNDI5NjkgMTYuMDc0MjE5IDI2LjQ4MDQ2OSBMIDEzLjY1MjM0NCAzMSBMIDkuODk0NTMxIDMxIEwgMTQuMzU1NDY5IDI0IEwgMTAuMjczNDM4IDE3IEwgMTQuMTA5Mzc1IDE3IEwgMTYuMTEzMjgxIDIxLjE5NTMxMyBDIDE2LjI2OTUzMSAyMS41MjczNDQgMTYuNDA2MjUgMjEuOTIxODc1IDE2LjUzMTI1IDIyLjM3NSBMIDE2LjU3MDMxMyAyMi4zNzUgQyAxNi42NDg0MzggMjIuMTA1NDY5IDE2Ljc5Njg3NSAyMS42OTUzMTMgMTcuMDExNzE5IDIxLjE1NjI1IEwgMTkuMjM4MjgxIDE3IEwgMjIuNzUzOTA2IDE3IEwgMTguNTU0Njg4IDIzLjkzNzUgTCAyMi44NjcxODggMzAuOTk2MDk0IEwgMTkuMTI4OTA2IDMwLjk5NjA5NCBaICI+PC9wYXRoPjwvZz48L3N2Zz4=') 50% 50% no-repeat;
	background-size: 100%; }

</style>
