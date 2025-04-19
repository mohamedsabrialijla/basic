import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

const store = new Vuex.Store({

		state() {
  return {
    name: 'John'
  }
},
		getters:{

			user:(state)=>{
				return state.user
			},
		},

		actions: {
   user({commit},user){
                commit('setCurrent', user)
            },
    },


		mutations: {
    setCurrent(state, payload) {
        state.name = payload
    }
},

	});


export default new Vuex.Store({
	name:'vuex'
});