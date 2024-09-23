<template>
  <div>
    <v-container fluid class="px-6 py-6">
      <v-row class="mt-8">
        <v-col cols="12">
          <admin-datatable-search></admin-datatable-search>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>
<script>
import AdminDatatableSearch from "./Widgets/UserDatatableSearch.vue";

export default {
  name: "admindatatables",
  components: {
      AdminDatatableSearch,
  },
};
</script>
