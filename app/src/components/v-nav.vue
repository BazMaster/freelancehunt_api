<template>
    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
            <a class="nav-link"
               :class="{ active: currentNav === 'all' }"
               @click.prevent="skillChanged('all')"
               href="#"
            >
                <span class="nav-title" :class="{ active: currentNav === 'all' }">Все проекты</span>
                <span class="badge">{{ data.all }}</span>
            </a>
        </li>
        <li class="nav-item" v-for="skill of data.skills">
            <a class="nav-link"
               :class="{ active: currentNav === skill.title }"
               href="#"
               @click.prevent="skillChanged(skill.title)"
            >
                <span class="nav-title" :class="{ active: currentNav === skill.title }">
                    {{ skill.title }}
                </span>
                <span class="badge">{{ skill.count }}</span>
            </a>
        </li>
    </ul>
</template>

<script>
    export default {
        name: 'nav',
        props: {
            currentNav: {
                type: String,
                default: 'all'
            },
            totalPages: {
                type: Number,
                default: 1
            },
        },
        data () {
            return {
                url: '/skills',
                data: []
            }
        },
        methods: {
            fetchSkills: function ($skill) {
                let options = {
                    params: {
                        'get': 'PHP,Веб-программирование,Базы данных',
                    }
                };

                let app = this;
                axios.get(this.url, options).then(function (response) {
                    // console.log(response);
                    // console.log(response.data.length);
                    app.data = response.data;
                    // app.total = response.data.total;
                }, console.log);
            },
            skillChanged: function ($skill) {
                this.currentNav = $skill;
                console.log('skillChanged', $skill);
                this.$emit('skill-changed', $skill);
            }
        },
        created: function () {
            this.fetchSkills()
        }
    }
</script>

<style scoped>
    .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
        background-color: #00ae5a;
    }
    .nav-link {
        font-size: 14px;
    }
</style>
