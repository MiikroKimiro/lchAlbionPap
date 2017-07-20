<template>
  <div class="container">
    <mu-card>
      <mu-card-text>
        <h2>{{ response }}</h2>
      </mu-card-text>
    </mu-card>
  </div>
</template>
<script>
  export default {
    props: ['response']
  }
</script>