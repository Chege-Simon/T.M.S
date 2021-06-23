<template>

  <div v-if="links.length > 3">

    <div class="pagination my-2">

      <template v-for="(link, k) in links" :key="k">

        <div v-if="link.url === null"  class="btn border text-sm rounded mx-1" v-html="link.label" />

        <inertia-link v-else class="btn border text-sm rounded mx-1 text-dark btn-muted" :class="{ 'bg-primary text-primary': link.active }" :href="link.url" v-html="link.label" />

      </template>

    </div>

  </div>

</template>

  

<script>

export default {

  props: {

    links: Array,

  },

}

</script> 