<template>
  <div>
    <v-container fluid class="px-6 py-6">
      <v-row class="mt-8">
        <v-col cols="12">
          <datatable-search></datatable-search>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>
<script>
import DatatableSearch from "./DatatableSearch.vue";

export default {
  name: "datatables",
  components: {
    DatatableSearch,
  }
};
</script>
