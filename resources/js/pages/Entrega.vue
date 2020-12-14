<template>
<div>
  <div if-v="prestamos===null"class="row">
    <div class="col-lg-8 m-auto">
      <card :title="$t('Entrega')">
        <form @submit.prevent="lookPrestamos" @keydown="form.onKeydown($event)">
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('identidad') }}</label>
            <div class="col-md-7">
              <input v-model="form.identidad" :class="{ 'is-invalid': form.errors.has('identidad') }" class="form-control" type="text" name="author">
              <has-error :form="form" field="identidad" />
            </div>
          </div>
          <div class="form-group row">
            <div class="col-md-7 offset-md-3 d-flex">
              <!-- Submit Button -->
              <v-button :loading="form.busy">
                {{ $t('Buscar Prestamos') }}
              </v-button>
            </div>
          </div>
        </form>
          <div>
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
                        <b-card-text>                
                         <b-button v-b-modal.modal-1 @click="onClick(prestamo)" >Entregar</b-button>
                        </b-card-text>
                        </b-card>
                        </b-col>
                        </b-row>
                    </b-container>
            </div>
      </card>
         <b-modal id="modal-1" title="Incidencia" @ok="handleOk">
        <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('Indidencia') }}</label>
            <div class="col-md-7">
              hay indicencia
              <input v-model="form.incidencia.has" :class="{ 'is-invalid': form.errors.has('incidencia.has') }" type="checkbox" name="incidenciaHas">
              libro obsoleto
              <input v-model="form.incidencia.obsoleto" :class="{ 'is-invalid': form.errors.has('incidencia.obsoleto') }" type="checkbox" name="indicenciaObsoleto">
              <input v-model="form.incidencia.descripcion" :class="{ 'is-invalid': form.errors.has('incidencia.descripcion') }" class="form-control" type="text" name="incidenciaDescripcion" placeholder="descripcion">
              <has-error :form="form" field="identidad" />
            </div>
          </div>
        </b-modal>   
    </div>
  </div>
</div>
</template>

<script>
import Form from 'vform'

export default {

  metaInfo () {
    return { title: this.$t('Entrega libro') }
  },

  data: () => ({
    form: new Form({
     identidad:"",
     prestamo:{},
     incidencia:{has:false,descripcion:'',obsoleto:false}
    }),
    prestamos:null
  }),

  methods: {
    async lookPrestamos () {
      // Register the user.
      const { data } = await this.form.post('api/encargado-prestamos')
          console.log('data',data)
          this.prestamos = data;
        // Redirect home.
      },
      onClick(prestamo){
          console.log('looking for entregar event',prestamo)
          this.form.prestamo = prestamo;
      },
     async handleOk(){
          console.log('looking at the form before hand',this.form)
          const{ data } = await this.form.post('api/encargado-entregar')
      }
    }
  }

</script>
