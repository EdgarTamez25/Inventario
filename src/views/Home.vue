<template>
  <v-container>
    <v-row class="justify-center">
      <v-col cols="12"  sm="10">

        <v-btn color="grey darken-4 " style="display: none" class="ir-arriba white--text" fab fixed bottom right>
          <v-icon top>keyboard_arrow_up</v-icon>
        </v-btn>

        <v-row>

          <v-col cols="9" sm="11">
            <v-text-field
                label="Buscar Articulo"
                dense
                outlined
                hide-details
                v-model="search"
                prepend-icon="search"
            ></v-text-field>
          </v-col>

          <v-col cols="1" sm="1">
            <ExpExcelArticulos/>
          </v-col>


          <v-col cols="6"  md="4" lg="3"  v-for="(item , i) in filterArticulos" :key="i">
            <v-hover v-slot:default="{ hover }" >
              <v-card class="mx-auto" max-width="350" v-ripple height="100%">

                <v-img aspect-ratio="1" contain :src="item.foto"  max-height="300px" min-height="300px">
                  <v-expand-transition>
                      <div
                        v-if="hover"
                        class="d-flex transition-fast-in-fast-out green darken-4 v-card--reveal display-3 white--text"
                        style="height: 100%;"
                      >
                        ${{ item.costo == 0 ? 'Indefinido': item.costo}}
                      </div>
                    </v-expand-transition>
                </v-img>

                <v-card-title > {{ item.nombre }} </v-card-title>
                <v-card-subtitle>Talla: {{ !item.talla ?'Indefinida': item.talla }}  </v-card-subtitle>
                <v-spacer></v-spacer>
              </v-card>
            </v-hover>
          </v-col>
        </v-row>
    </v-col>
    </v-row>

  </v-container>
</template>

<script>
  import ExpExcelArticulos from '@/views/ExpExcelArticulos'
  import $ from 'jquery'
  import {mapGetters, mapActions} from 'vuex'
export default {
  components: {
    ExpExcelArticulos
  },
  data: () => ({
      show: false,
      articulos: [],
      search: ''
  }),

  methods:{
    ...mapActions('Actualizador',['actualizaArticulos','consultarArticulos']),


	},

  computed:{
    ...mapGetters('Actualizador',['getArticulos']),

    filterArticulos: function(){
      return this.getArticulos.filter((art)=>{
        var nom = art.nombre.toLowerCase();
        return nom.match(this.search.toLowerCase());
      })
    },

  },

  // filters:{
  //   toUppercase(value){
  //     return value.toUpperCase();
  //   }
  // },

  created(){
    this.consultarArticulos();
    // this.consultarArt();
  },

  mounted(){
    // Jquey para activar la animacion del boton hacia arriba
    $(document).ready(function(){

      $('.ir-arriba').click(function(){
        $('body, html').animate({
          scrollTop: '0px'
        }, 300);
      });
      
      $(window).scroll(function(){
        if( $(this).scrollTop() > 0 ){
          $('.ir-arriba').slideDown(300);
        } else {
          $('.ir-arriba').slideUp(300);
        }
      });
      
    });

  },


}
</script>
<style>
.v-card--reveal {
  align-items: center;
  bottom: 0;
  justify-content: center;
  opacity: .5;
  position: absolute;
  width: 100%;
}
</style>
