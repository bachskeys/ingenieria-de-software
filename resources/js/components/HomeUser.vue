<template>
  <div>
    Bienvenido al sistema de biblioteca {{user.name}}<br>
    su clave de identidad es {{user.numeroIdentidad}}
  </div>
</template>

<script>
import axios from 'axios'
import { mapGetters } from 'vuex'


export default {
   computed: mapGetters({
    user: 'auth/user'
  }),
  mounted () {
    axios.get('/api/users')
      .then(response => console.log(response.data))
  }
}
</script>
