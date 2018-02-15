<template lang="html">    
    <input type="text" class="form-control" placeholder="Enter item name" :value="labelText" v-on:keyup.enter="enterPressed" />
</template>

<script>
export default {
  name: 'list-item',
  props: ['labelText'],
  methods: {
    enterPressed(event){
        // event.target.blur();
    },
    updateCode(labelText){
        // this.$emit('input', labelText);
    }
  }
};
</script>