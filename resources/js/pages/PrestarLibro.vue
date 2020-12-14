<template>
  <div class="row">
    <div class="col-lg-8 m-auto">
      <card :title="$t('prestar libro')">
      <b-container class="bv-example-row">
      <b-row v-for="libro in libros" :key="libro.id" class="row">
        <b-col>
            <b-card
                v-if='libro.copias===true'
                :title="libro.titulo"
                img-top
                tag="libro"
                style="max-width: 20rem;"
                class="mb-2"
            >
               <b-card-text>
                author:   {{libro.author}}
                </b-card-text>
                <b-card-text>
                {{libro.descripcion}}
                </b-card-text>
                <b-card-text>
                </b-card-text>
                 <b-button v-b-modal.modal-1 @click="onClick(libro.id)" >prestar</b-button>
                </b-card>
                </b-col>
                </b-row>
                </b-container>
      </card>
        <b-modal id="modal-1" title="Identidad" @ok="handleOk">
        <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('identidad') }}</label>
            <div class="col-md-7">
              <input v-model="form.identidad" :class="{ 'is-invalid': form.errors.has('identidad') }" class="form-control" type="text" name="identidad">
              <has-error :form="form" field="identidad" />
            </div>
          </div>
        </b-modal>     
    </div>
  </div>
</template>

<script>
import Form from 'vform'
import {mapActions,mapGetters} from "vuex";
export default {

  metaInfo () {
    return { title: this.$t('prestar libro') }
  },

  data: () => ({
      form: new Form({
      id:null,
      identidad:'',
    }),
  }),
  computed:{
      ...mapGetters({
          libros:'articulos/libros'
      })
  },
  methods: {
      ...mapActions({fetchLibros:'articulos/fetchLibros'}),
      onClick(id){
          console.log('hereeee')
          this.form.id = id;
      },
      handleOk(){
          console.log("looking for the form before post",this.form)
          this.form.post('api/prestar');
          this.$router.push({ name: 'home' })

      }
    },
    mounted(){
        this.fetchLibros();
    }
  }

</script>