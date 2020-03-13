<template>
    <div>
        <v-pagination
            v-model="currentPage"
            :page-count="totalPages"
            :classes="bootstrapPaginationClasses"
        ></v-pagination>
    </div>
</template>

<script>
    import vPagination from 'vue-plain-pagination'

    export default {
        components: { vPagination },
        props: {
            currentPage: {
                type: Number,
                default: 1
            },
            totalPages: {
                type: Number,
                default: 1
            },
        },
        data() {
            return {
                bootstrapPaginationClasses: {
                    ul: 'pagination justify-content-center',
                    li: 'page-item',
                    liActive: 'active',
                    liDisable: 'disabled',
                    button: 'page-link'
                }
            }
        },
        methods: {
            changePage () {
                this.$emit('page-changed', this.currentPage);
                // console.log(this.currentPage);
            }
        },
        watch: {
            currentPage: 'changePage'
        }
    }
</script>

<style scoped>
    .page-item.active .page-link {
        background-color: #00ae5a;
        border-color: #00ae5a;
    }
</style>
