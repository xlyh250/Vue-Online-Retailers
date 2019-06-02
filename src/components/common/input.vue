<template>
   <div>   
       <input type="checkbox" value="66" v-model="check">
       <label  for="color-input-red"></label >
    </div>
</template>

<script>
export default {
  props:{
    check:true,
  },
  data () {
    return {
    };
  },

  components: {
  },
  computed: {
  },
  methods: {
  }
}

</script>
<style scoped lang="stylus">
       input[type=checkbox]{
          position: absolute;
          top: 0;
          left: .3rem;
          z-index 9999
          opacity 0
       }
       input[type=checkbox] + label{
            display: block;
            width: 1rem;
            height: 1rem;
            border-radius:50%;
            cursor: pointer;
            position: relative;
            top: 0;
            left: .3rem;
            background: rgba(240, 84, 77, 1);
          }
       input[type=checkbox]:checked + label::before{
            display: block;
            content: "\2714";
            text-align: center;
            font-size: 16px;
            color: white;
          }
</style>
