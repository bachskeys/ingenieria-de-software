<template>
  <div class="row">
    <div class="col-lg-8 m-auto">
      <card v-if="mustVerifyEmail" :title="$t('register')">
        <div class="alert alert-success" role="alert">
          {{ $t('verify_email_address') }}
        </div>
      </card>
      <card v-else :title="$t('Alta Revista')">
        <form @submit.prevent="register" @keydown="form.onKeydown($event)">
          <!-- titulo -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('titulo') }}</label>
            <div class="col-md-7">
              <input v-model="form.titulo" :class="{ 'is-invalid': form.errors.has('titulo') }" class="form-control" type="text" name="titulo">
              <has-error :form="form" field="titulo" />
            </div>
          </div>

          <!-- descripcion -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('descripcion') }}</label>
            <div class="col-md-7">
              <input v-model="form.descripcion" :class="{ 'is-invalid': form.errors.has('descripcion') }" class="form-control" type="text" name="descripcion">
              <has-error :form="form" field="descripcion" />
            </div>
          </div>
          <!-- copias -->
          <div class="form-group row">
            <label class="col-md-3 col-form-label text-md-right">{{ $t('copias') }}</label>
            <div class="col-md-7">
              <input v-model="form.copias" :class="{ 'is-invalid': form.errors.has('copias') }" class="form-control" type="number" name="copias">
              <has-error :form="form" field="copias" />
            </div>
          </div>
          <div class="form-group row">
            <div class="col-md-7 offset-md-3 d-flex">
              <!-- Submit Button -->
              <v-button :loading="form.busy">
                {{ $t('dar de alta') }}
              </v-button>
            </div>
          </div>
        </form>
      </card>
    </div>
  </div>
</template>

<script>
import Form from 'vform'

export default {

  metaInfo () {
    return { title: this.$t('alta libro') }
  },

  data: () => ({
    form: new Form({
      titulo: '',
      descripcion: '',
      copias: '',
      imagen:null,
    }),
  }),

  methods: {
    async register () {
      // Register the user.
      console.log('looking at the form before request',this.form)
      const { data } = await this.form.post('api/crear/revista')
          console.log('data',data)
        // Redirect home.
        this.$router.push({ name: 'home' })
      },
    selectFile(e){
         const file = e.target.files[0]
          this.form.imagen = file
    }
    }
  }

</script>