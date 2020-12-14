<template>
     <b-container class="bv-example-row">
      <b-row v-for="prestamo in prestamos" :key="prestamo.id" class="row">
        <b-col>
            <b-card
                :title="prestamo.titulo"
                img-top
                tag="libro"
                style="max-width: 20rem;"
                class="mb-2"
            >
               <b-card-text>
                author:   {{prestamo.author}}
                </b-card-text>
                <b-card-text>
                {{prestamo.descripcion}}
                </b-card-text>
                <b-card-text>
                fecha de entrega: {{prestamo.fecha_entrega}}
                </b-card-text>
                </b-card>
                </b-col>
                </b-row>
            </b-container>
</template>

<script>
import axios from 'axios'
import { mapGetters,mapActions} from 'vuex'


export default {
   computed: mapGetters({
    user: 'auth/user',
    prestamos:'articulos/userPrestamos'
  }),
  methods:{
      ...mapActions({
        getUserPrestamos:'articulos/fetchUserPrestamos'
      })

  },
  mounted () {
      this.getUserPrestamos();
} }
</script>
