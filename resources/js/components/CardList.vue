<template>
    <v-app id="card-list">
        <h2>カード一覧</h2>
        <div class="col-sm-12">
            <v-data-table
                :headers="headers"
                :items="cards"
                :page.sync="page"
                :items-per-page="itemsPerPage"
                :total-visible="totalVisible"
                hide-default-footer
                @page-count="pageCount = $event"
            >
                <template v-slot:item.symbol="{ item }">
                    <v-chip
                        v-if="item.symbol != null"
                        :color="item.symbol_color"
                        dark
                    >
                        {{ item.symbol }}
                    </v-chip>
                </template>
                <template v-slot:item.actions="{ item }">
                    <v-icon
                        small
                        class="mr-2"
                        @click="editItem(item)"
                    >
                        mdi-pencil
                    </v-icon>
                    <v-icon
                        small
                        @click="deleteItem(item)"
                    >
                        mdi-delete
                    </v-icon>
                </template>
            </v-data-table>
            <div class="text-center py-2">
                <v-pagination
                    v-model="page"
                    :length="pageCount"
                    :total-visible="totalVisible"
                    circle
                    prev-icon="mdi-menu-left"
                    next-icon="mdi-menu-right"
                />
            </div>
        </div>
        <!-- エラーメッセージ -->
        <p v-if="message">{{ message }}</p>
    </v-app>
</template>

<script>
import config  from '../const'

export default {
    data() {
        return {
            headers: [
                {
                    text: config.folderName,
                    value: 'folder_name'
                },
                {
                    text: config.titleName,
                    value: 'title'
                },
                {
                    text: config.rarityName,
                    value: 'rarity'
                },
                { text: config.symbolName,
                    value: 'symbol'
                },
                {
                    text: config.cardName,
                    value: 'name',
                },

                { text: '枚数',
                    value: 'amount'
                },
            ],
            message: "",
            cards: [],
            updateId: -1,
            dialog: false,
            page: 1,
            pageCount: 0,
            itemsPerPage: 20,
            totalVisible: 7,
        };
    },
    created: function() {
        this.initialize();
    },
    computed: {
    formTitle () {
        return this.updateId === -1 ? '新規追加' : '編集'
        },
    },
    methods: {
        initialize() {
            this.getCard();
        },
        getCard() {
            axios
                .get("/api/cards/")
                .then(response => {
                    this.cards = response.data;
                })
                .catch(err => {
                    this.message = err;
                });
        },
    }
};
</script>