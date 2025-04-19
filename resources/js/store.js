import { createStore } from 'vuex';
import axios from 'axios'; // تأكد من استيراد axios هنا

const store = createStore({
    state: {
        user: null,
        languages: [],
        projectItem: JSON.parse(localStorage.getItem('projectItem')) || null, // استرداد البيانات من localStorage
        currentLanguage: 'en', 
    },
    mutations: {
        setUser(state, user) {
            state.user = user;
        },
        setLanguages(state, languages) {

            state.languages = languages;

        },

        setprojectItem(state, projectItem) {
            state.projectItem = projectItem;
            localStorage.setItem('projectItem', JSON.stringify(projectItem)); // حفظ في localStorage
        },

          setCurrentLanguage(state, language) {
            state.currentLanguage = language;
         },
    },
    actions: {
        // login({ commit }, user) {
        //     commit('setUser', user);
        // },
        // logout({ commit }) {
        //     commit('setUser', null);
        // },
        fetchLanguages({ commit }) {
            return axios.get('Languages/getAllItems') // تأكد من أن الرابط صحيح
                .then(response => {
                    commit('setLanguages', response.data.items);
                })
                .catch(error => {
                    console.log("Error fetching languages:", error);
                });
        },

        fetchUser({ commit }) {
            return axios.get('UserAuth/getAuth') // تأكد من أن الرابط صحيح
                .then(response => {
                    commit('setUser', response.data.items);
                 
                })
                .catch(error => {
                    console.log("Error fetching User auth:", error);
                });
        },
    },
    getters: {
        getLanguages(state) {
            return state.languages;
        },
        getUser(state) {
          return state.user;
        },

        isAuthenticated(state) {
            return !!state.user;
        },
        getCurrentLanguage(state) {
            return state.currentLanguage;
        },

        getprojectItem(state) {
            return state.projectItem;
        },
    },
});

export default store;
