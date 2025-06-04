<template>
    <div class="container">
        
        Pricing here List 

    </div>
</template>

<script>
import { mapActions, mapState } from "vuex";
// import Slider from './Slider.vue';

export default {
    name: "Header",
    components: {
        // Slider,
    },

    data() {
        return {
            urlEditInfo: "Users/editItem",
            urlEditPassword: "Users/editItemPassword",
            isLoading: false,
            logo: "",
            logo_preview: "./../assets/media/avatars/300-1.jpg",

            formData: {
                pass: "",
                cpass: "",
            },

            result: [],
            percentage: 0,
            sections: [],
        };
    },

    computed: {
        user() {
            return this.$store.getters.getUser || {};
        },

        locale() {
            return this.$route.params.locale;
        },

     
    },

    mounted() {
        
    },

    methods: {
        
      

      
    },
};
</script>
