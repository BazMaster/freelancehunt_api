<template>
    <div id="chart">
        <GChart
            type="PieChart"
            :data="chartData"
            :options="chartOptions"
        />
    </div>
</template>

<script>
    import { GChart } from "vue-google-charts";
    export default {
        name: "chart",
        components: {
            GChart
        },
        data () {
            return {
                chartDataHeader: ['Категория', 'Количество'],
                chartDataRows: [],
                url: 'http://freelancehunt.loc/stat',
                chartOptions: {
                    chart: {
                        title: 'По ценам',
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            }
        },
        computed: {
            chartData () {
                return [ this.chartDataHeader, ...this.chartDataRows ]
            }
        },
        methods: {
            updateData () {

                let options = {
                    params: {
                        'get': 'PHP,Веб-программирование,Базы данных',
                    }
                };

                let app = this;
                axios.get(this.url, options).then(function (response) {
                    console.log('chart1', app.chartDataRows);
                    console.log('chart', response.data);
                    app.chartDataRows = response.data;
                }, console.log);



            }
        },
        created () {
            this.updateData()
        }
    };
</script>


<style scoped>

</style>
