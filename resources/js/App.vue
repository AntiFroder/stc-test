<template>
    <div class="filters">
        <select v-model="filters.author">
            <option :value=null disabled>Авторы</option>
            <option
                v-for="author in authors"
                :value="author.id"
            >
                {{ author.full_name }}
            </option>
        </select>
        <button
            @click="clearFilters"
        >
            Очистить фильтр
        </button>
    </div>
    <div class="table">
        <table class="data-table">
            <thead>
            <tr>
                <th v-for="head in headers">
                    {{ head.title }}
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="book in books">
                <td>{{ book.id }}</td>
                <td>{{ book.title }}</td>
                <td>{{ book.authors }}</td>
                <td>{{ book.author_count }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
import axios from "axios";

export default {
    data() {
        return {
            books: null,
            filters: {
                author: null,
            },
            authors: null
        }
    },
    computed: {
        headers() {
            return [
                {
                    title: '№ п\\п'
                },
                {
                    title: 'Название книги'
                },
                {
                    title: 'Авторы'
                },
                {
                    title: 'Кол-во авторов'
                },
            ]
        }
    },
    created() {
        this.init()
        this.setFilters()
    },
    watch: {
        'filters.author': function (val) {
            this.init()
        }
    },
    methods: {
        async init() {
            await axios.post('http://localhost:8000/api/books/datatable', this.filters)
                .then(({data}) => {
                    this.books = data
                })
        },
        async setFilters() {
            await axios.get('http://localhost:8000/api/books/filters-data')
                .then(({data}) => {
                    this.authors = data
                })
        },
        clearFilters () {
            this.filters.author = null
        }
    }
}
</script>
<style>
.data-table {
    width: 50%;
    border-collapse: collapse;
}

.data-table td,
.data-table th {
    border: 1px solid #ddd;
    padding: 8px;
}
.filters {
    display: flex;
    margin: 10px;
    width: 30%;
}
.table {
    margin: 10px;
}
button {
    flex: 1 1 auto;
    margin: 0 5px;
    background-color: lightblue;
    border-radius: 3px;
    border: 1px solid lightblue;
    min-height: 40px;
}
select {
    margin: 0 5px;
    flex: 1 1 auto;
    border: 1px solid #ddd;
    min-height: 40px;
}
</style>
