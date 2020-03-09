<template>
  <v-app id="inspire">
    <v-content class="ma-1" text >
      <router-view/>
    </v-content>

    <v-app-bar app color="green darken-4" dark class="elevation-0" v-ripple >
      <v-list-item-avatar class="elevation-12">
        <img src="logo.jpg" :to="{name: '/addArt'}">
      </v-list-item-avatar>
      <v-spacer></v-spacer>
      
      <v-toolbar-items text-right  >
          <v-btn text dark @click="dialog=true"><v-icon >note_add </v-icon></v-btn>
      </v-toolbar-items>
    </v-app-bar>

    <v-dialog v-model="dialog" persistent max-width="700px">
      <v-card class="pa-3">
        <AddArt  @modal="dialog = $event"></AddArt>
      </v-card>
    </v-dialog>

    <v-footer color="grey lighten-1" >
        <v-list-item-avatar class="elevation-12">
          <img src="uanl.jpg" :to="{name: '/'}">
        </v-list-item-avatar>
        <strong >  Universidad Autónoma de Nuevo León </strong>
        <v-spacer></v-spacer>
    </v-footer>

   
  </v-app>
</template>

<script>
  import AddArt from '@/views/addArt.vue'
export default {
  components: {
    AddArt
  },
  data: () => ({
    dialog: false
    
  }),
};
</script>


