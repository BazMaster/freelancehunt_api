<template>
  <div id="app">
    <h1>{{ msg }}</h1>
    {{ url }} ({{ total }}) - {{ pageCount }} - {{ paginatedData }}
    <hr>
    <Pagination></Pagination>

    <div>
      <ul>
        <li v-for="p in paginatedData">
          {{p.first}}
          {{p.last}}
          {{p.suffix}}
        </li>
      </ul>
      <button @click="prevPage":disabled="currentPage==0">
        Previous
      </button>
      <button @click="nextPage":disabled="currentPage >= pagecount -1">
        Next
      </button>
    </div>

    <div v-for="project in data" class="text-left">
      <h3>{{ project.id }}. <a :href="project.link" target="_blank">{{ project.title }}</a></h3>
      <em>{{ project.skills }}</em>
    </div>
    <hr>
    <pre><code>{{ data }}</code></pre>

  </div>
</template>

<script>
  import Pagination from './components/v-pagination.vue'
  export default {
    name: 'app',
    data () {
      return {
        url: 'http://freelancehunt.loc/list',
        msg: 'Welcome to Your Vue.js App',
        data: null,
        total: 0,
        perPage: 3,
        currentPage: 2
      }
    },
    methods: {
      fetchProjects: function () {
        let options = {
          params: {
            'limit': 3,
            'page': 5,
            'skill': 'PHP'
          }
        };

        let app = this;
        axios.get(this.url, options).then(function (response) {
          // console.log(response);
          // console.log(response.data.length);
          app.data = response.data.projects;
          app.total = response.data.total;
        }, console.log);
      },
      nextPage(){
        this.currentPage++;
        console.log(this.currentPage);
      },
      prevPage(){
        this.currentPage--;
        console.log(this.currentPage);
      }
    },
    computed: {
      pageCount(){
        let l = this.total,
          s = this.perPage;
        return Math.ceil(l/s);
      },
      paginatedData(){
        const start = this.currentPage * this.total,
          end = start + this.total;
        return this.data.slice(start, end);
      }
    },
    created: function () {
      this.fetchProjects(this.currentPage)
    },
    components: {
      Pagination
    }
    // mounted() {
    //   axios
    //     .get(this.url)
    //     .then(response => (this.data = response.data));
    // }
  }
</script>

<style lang="scss">
  #app {
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
    margin-top: 60px;
  }

  h1, h2 {
    font-weight: normal;
  }

  .text-left {
    text-align: left;
  }

  ul {
    list-style-type: none;
    padding: 0;
  }

  li {
    display: inline-block;
    margin: 0 10px;
  }

  a {
    color: #42b983;
  }
  pre {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: left;
  }
</style>
