<template>
    <page-wrapper>
        <template v-slot:title>
            Sites list
        </template>
        <template v-slot:content>
            <monitor-list></monitor-list>
        </template>
    </page-wrapper>
</template>
<script>
  import PageWrapper from '@/components/PageWrapper.vue';
  import MonitorList from '@/components/MonitorList.vue';

  export default {
    components: {
      PageWrapper,
      MonitorList
    }
  }
</script>
