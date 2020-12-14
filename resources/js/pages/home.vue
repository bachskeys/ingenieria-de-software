<template>
<div>
  <card :title="$t('home')" class="mt-5">
    <home-user />
  </card>
   <card :title="$t('Prestamos')" class="mt-5">
    <UserPrestamos />
  </card>
</div>
</template>

<script>
import HomeUser from '~/components/HomeUser'
import UserPrestamos from '~/components/UserPrestamos.vue'
export default {
  components: {
    HomeUser,
    UserPrestamos
  },
  middleware: 'auth',

  metaInfo () {
    return { title: this.$t('home') }
  }
}
</script>
