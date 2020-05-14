<template>
  <div :user="user" :message="message" class="sc-message--emoji">
    <div v-if="!me" class="sc-user">{{user.name}}</div>
    {{data.emoji}}
  </div>
</template>

<script>
export default {
  props: {
    data: {
      type: Object,
      required: true
    },
    user: {
      type: Object,
      required: true
    },
    message:{
      type: Object,
      required: true
    },
    message:{
      type: Object,
      required: true
    },
    authorId: {
      type: Number,
      required: true
    }
  },
  computed: {
    me() {
      return this.message.author === this.authorId;
    },
  }
}
</script>

<style scoped>
.sc-message--emoji {
  font-size: 40px;
}
</style>
