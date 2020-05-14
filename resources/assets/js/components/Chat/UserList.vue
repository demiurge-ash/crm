<template>
  <div class="user-list">
    <table class="" style="padding-top: 5px">
      <tbody>
        <tr v-for="user in participants" :key="user.id" v-bind:class="{ online: user.online,  offline: !user.online }">
            <td style="text-align: center;"><img :src="user.imageUrl" class="img-msg"/></td>
            <td class="user-element">{{ user.name }}</td>
        </tr>
      </tbody>
  </table>
  </div>
</template>
<script>
export default {
  props: {
    participants: {
      type: Array,
      required: true
    }
  }
}
</script>
<style scoped>
  .user-list {
    height: 100%;
    overflow: auto;
    padding-left: 10px;
    padding-top: 10px;
  }
  .img-msg {
    border-radius: 50%;
    width: 40px;
    margin-right: 7px;
  }
  .user-element {
    font-size: 14px;
    vertical-align: middle;
  }
  .user-list .offline {
      opacity: 0.5;
  }
  .user-list .online {
      opacity: 1;
  }
</style>
