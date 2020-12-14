function page (path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
  { path: '/', name: 'welcome', component: page('auth/login.vue') },
  { path: '/about', name: 'about', component: page('about.vue') },

  { path: '/login', name: 'login', component: page('auth/login.vue') },
  { path: '/register', name: 'register', component: page('auth/register.vue') },
  { path: '/password/reset', name: 'password.request', component: page('auth/password/email.vue') },
  { path: '/password/reset/:token', name: 'password.reset', component: page('auth/password/reset.vue') },
  { path: '/email/verify/:id', name: 'verification.verify', component: page('auth/verification/verify.vue') },
  { path: '/email/resend', name: 'verification.resend', component: page('auth/verification/resend.vue') },
  
  { path: '/home', name: 'home', component: page('home.vue') },
  { path: '/settings',
    component: page('settings/index.vue'),
    children: [
      { path: '', redirect: { name: 'settings.profile' } },
      { path: 'profile', name: 'settings.profile', component: page('settings/profile.vue') },
      { path: 'password', name: 'settings.password', component: page('settings/password.vue') }
    ] },
    { path: '/alta-libro', name: 'alta-libro', component: page('AltaLibro.vue') },
    { path: '/alta-revista', name: 'alta-revista', component: page('AltaRevista.vue') },
    { path: '/libro-prestar', name: 'libro-prestar', component: page('PrestarLibro.vue') },
    { path: '/libro-entregar', name: 'libro-entregar', component: page('Entrega.vue') },



  { path: '*', component: page('errors/404.vue') }
]
