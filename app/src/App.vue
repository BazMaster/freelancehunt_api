<template>
  <div id="app">

      <div class="container">
          <div class="row">
              <div class="col-lg-3 col-md-3 pt-md-4">
                  <h3>Категории</h3>
                  <Navigation
                      @skill-changed="fetchProjects(1, $event)"
                  ></Navigation>

                  <hr>

                  <h5>По ценам:</h5>
                  <Chart></Chart>

              </div>
              <div class="col-lg-9 col-md-9 py-md-3 pb-5 mb-5">
                  <h1>{{ title }}</h1>
                  <hr>
                  <Pagination
                      :current-page="currentPage"
                      :totalPages="totalPages"
                      @page-changed="fetchProjects($event)"
                  >
                  </Pagination>

                  <div v-for="project in data" class="card my-2">
                      <div class="card-body">
                          <h5 class="card-title"><a :href="project.link" target="_blank">{{
                              project.title }}</a></h5>

                          <div class="text-muted mb-2">{{ project.skills }}</div>

                          <div>
                              <div class="avatar-container avatar-container-25">
                                  <img :src="project.employer_avatar"
                                       class="vertical avatar-container avatar-container-25" :alt="project.employer_fullname"
                                       width="25" height="25">
                              </div>
                              <a :href="'https://freelancehunt.com/employer/' + project.employer_login + '.html'"
                                 target="_blank" :title="'Профиль заказчика' + project.employer_login">
                                  {{ project.employer_fullname }}</a>
                              &nbsp;|&nbsp;
                              <small class="text-muted">
                                  {{ project.published_at | formatDate }}
                              </small>
                              <span class="text-green price float-right" title="Бюджет" v-if="project.budget_amount">
                                  {{ project.budget_amount }} {{ project.budget_currency }}
                              </span>

                          </div>
                      </div>
                  </div>

              </div>
          </div>
      </div>



  </div>
</template>

<script>
  import Pagination from './components/v-pagination.vue'
  import Navigation from './components/v-nav.vue'
  import Chart from './components/v-chart.vue'
  export default {
    name: 'app',
    props: {
        currentPage: {
          type: Number,
          default: 1
        },
        total: {
          type: Number,
          default: 0
        },
        perPage: {
          type: Number,
          default: 10
        },
        totalPages: {
          type: Number,
          default: 0
        },
        title: {
          type: String,
          default: 'Все проекты'
        }
    },
    data () {
      return {
        url: '/list',
        data: null
      }
    },
    methods: {
      fetchProjects: function ($page = 1, $skill = null) {
          let navTitle = $('.nav-title.active').text().trim();
          if(navTitle === 'Все проекты') navTitle = 'all';
        console.log('fetchProjects', $page, $skill, navTitle);
        if($page > 0) {
            this.currentPage = $page;
        }
        let options = {
          params: {
            'limit': this.perPage,
            'page': this.currentPage
          }
        };
        if($skill === null) {
            $skill = navTitle;
        }
        if($skill !== null && $skill !== 'all') {
            options = {
                params: {
                    'limit': this.perPage,
                    'page': this.currentPage,
                    'skill': $skill
                }
            };
        }

        let app = this;
        axios.get(this.url, options).then(function (response) {
          app.data = response.data.projects;
          app.total = response.data.total;
        }, console.log);
      },
    },
    created: function () {
      this.fetchProjects(this.currentPage)
    },
    components: {
      Pagination,
      Chart,
      Navigation
    },
      computed: {
          totalPages: function() {
              let l = this.total,
                  s = this.perPage;
              return Math.ceil(l/s);
          }
      }
    // ,
    // watch: {
    //   data () {
    //       this.setPages();
    //   }
    // }
  }
</script>

<style lang="scss">
    .price {
        font-size: 1.8em;
        white-space: nowrap;
        text-decoration: none;
        margin-top: -10px;
    }
    .avatar-container {
        border-radius: 50%;
        background-repeat: no-repeat;
        position: relative;
        display: inline-block;
    }
    .avatar-container-25 {
        width: 25px;
        max-width: 100%;
        height: auto;
        max-height: 25px;
        background-size: 25px 25px;
    }
    .vertical {
        vertical-align: middle!important;
    }
</style>
