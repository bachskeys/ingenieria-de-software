import axios from 'axios'
import Cookies from 'js-cookie'
import * as types from '../mutation-types'

// state
export const state = {
  libros:[],
  revistas:[],
  prestamos:[],
}

// getters
export const getters = {
  libros: state => state.libros,
  revistas: state => state.revistas,
  userPrestamos: state => state.prestamos,
}

// mutations
export const mutations = {
  [types.SET_LIBROS] (state,libros) {
    state.libros = libros
  },
  [types.SET_REVISTAS] (state,revistas) {
    state.revistas = revistas
  },
  [types.SET_REVISTAS] (state,revistas) {
    state.revistas = revistas
  },
  [types.SET_USER_PRESTAMOS] (state,prestamos) {
    state.prestamos = prestamos
  },
}

// actions
export const actions = {


  async fetchLibros ({ commit }) {
    try {
      const { data } = await axios.get('api/libros')
      commit(types.SET_LIBROS,data)
    } catch (e) {
            console.log('there was an error',e)
    }
  },

  async fetchRevistas ({ commit }) {
    try {
      const { data } = await axios.get('/revistas')
        console.log('looking for revistas',data)
      //commit(types.SET_LIBROS, { user: data })
    } catch (e) {
            console.log('there was an error',e)
    }
  },

  async fetchUserPrestamos({ commit }){
    try{
      const { data } = await axios.get('api/user/prestamos')
      console.log('loggin user prestamos',data)
      commit(types.SET_USER_PRESTAMOS,data)

    }catch(e){

    }
  }
}
