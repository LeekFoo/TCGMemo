<template>
    <v-app id="folder-card-list">
        <v-card>
            <v-card-title>
                <h2>{{ folderName }} - カード一覧</h2>
                <v-spacer></v-spacer>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="カード名"
                    single-line
                    hide-details
                ></v-text-field>
            </v-card-title>
            <v-data-table
                :headers="headers"
                :items="cards"
                :page.sync="page"
                :items-per-page="itemsPerPage"
                :total-visible="totalVisible"
                :search="search"
                hide-default-footer
                @page-count="pageCount = $event"
            >
                <template v-slot:item.title="{ item }">
                    {{ convertTitle(item.title_cd) }}
                </template>
                <template v-slot:item.rarity="{ item }">
                    {{ convertRarity(item.rarity_cd) }}
                </template>
                <template v-slot:item.symbol="{ item }">
                    <v-chip
                        v-if="item.symbol_cd != null"
                        :color="convertSymbolColor(item.symbol_cd)"
                        dark
                    >
                        {{ convertSymbol(item.symbol_cd) }}
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
            <!-- エラーメッセージ -->
            <p v-if="message">{{ message }}</p>
        </v-card>
        <v-dialog
            v-model="dialog"
            max-width="500px"
        >
            <template v-slot:activator="{ on, attrs }">
                <v-btn
                    color="primary"
                    dark
                    class="mb-2"
                    v-bind="attrs"
                    v-on="on"
                >
                    カードを追加
                </v-btn>
            </template>
            <v-card>
                <v-card-title>
                    <span class="headline">{{ formTitle }}</span>
                </v-card-title>

                <v-form ref="card_form">
                    <v-card-text>
                        <v-container>
                        <v-row>
                            <v-col
                                cols="12"
                                sm="6"
                                md="4"
                            >
                            <v-select
                                v-model="updateItem.title_cd"
                                label="収録弾"
                                :items="titles"
                                item-text="title"
                                item-value="id"
                            >
                            </v-select>
                            </v-col>
                            <v-col
                                cols="12"
                                sm="6"
                                md="4"
                            >
                            <v-select
                                v-model="updateItem.rarity_cd"
                                label="レアリティ"
                                :items="rarities"
                                item-text="name"
                                item-value="id"
                                required
                            >
                            </v-select>
                            </v-col>
                            <v-col
                                cols="12"
                                sm="6"
                                md="4"
                            >
                            <v-select
                                v-model="updateItem.symbol_cd"
                                label="シンボル"
                                :items="symbols"
                                item-text="name"
                                item-value="id"
                                required
                            >
                            </v-select>
                            </v-col>
                            <v-col
                                cols="12"
                                sm="6"
                                md="4"
                            >
                            <v-text-field
                                v-model="updateItem.name"
                                label="カード名"
                                :rules="[required]"
                            ></v-text-field>
                            </v-col>
                            <v-col
                                cols="12"
                                sm="6"
                                md="4"
                            >
                            <v-text-field
                                v-model="updateItem.amount"
                                label="枚数"
                            ></v-text-field>
                            </v-col>
                        </v-row>
                        </v-container>
                    </v-card-text>
                </v-form>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="close"
                    >
                        キャンセル
                    </v-btn>
                    <v-btn
                        color="blue darken-1"
                        text
                        @click="save"
                    >
                        保存
                    </v-btn>
                </v-card-actions>
                </v-card>
            </v-dialog>
    </v-app>
</template>

<script>
import config  from '../const'

export default {
    props: {
        folderId: Number
    },
    computed: {

        formTitle () {
            return this.updateId === -1 ? '新規追加' : '編集'
        },
    },
    data() {
        return {
            headers: [
                { text: 'ID', value: 'id'},
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
                { text: '操作',
                    value: 'actions',
                    sortable: false
                },
            ],
            message: "",
            updateForm: false,
            folderName: null,
            cards: [],
            symbols: [],
            rarities: [],
            titles: [],
            search: null,
            updateId: -1,
            updateItem: {
                id: null,
                folder_id: null,
                title_cd: null,
                title: null,
                rarity_cd: null,
                rarity: null,
                card_no: null,
                name: null,
                symbol_cd: null,
                symbol: null,
                symbol_color: null,
                amount: null
            },
            defaultItem: {
                id: null,
                folder_id: null,
                title_cd: null,
                title: null,
                rarity_cd: null,
                rarity: null,
                card_no: null,
                name: null,
                symbol_cd: null,
                symbol: null,
                symbol_color: null,
                amount: null
            },
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

    methods: {
        initialize() {
            this.getCard();
            this.getSymbols();
            this.getRarities();
            this.getTitles();
        },
        getSymbols() {
            axios
                .get("/api/symbols/")
                .then(response => {
                    this.symbols = response.data;
                })
                .catch(err => {
                    this.message = err;
                });
        },
        getRarities() {
            axios
                .get("/api/rarities/")
                .then(response => {
                    this.rarities = response.data;
                })
                .catch(err => {
                    this.message = err;
                });
        },
        getTitles() {
            axios
                .get("/api/titles/")
                .then(response => {
                    this.titles = response.data;
                })
                .catch(err => {
                    this.message = err;
                });
        },
        getCard() {
            axios
                .get("/api/folders/" + this.folderId)
                .then(response => {
                    this.folderName = response.data.name;
                    this.cards = response.data.cards;
                })
                .catch(err => {
                    this.message = err;
                });
        },
        editItem (item) {
            this.updateId = this.cards.indexOf(item)
            this.updateItem = Object.assign({}, item)
            this.dialog = true
        },
        close () {
            this.dialog = false
            this.$nextTick(() => {
                this.updateItem = Object.assign({}, this.defaultItem)
                this.updateId = -1
            })
        },
        deleteItem (item) {
            const index = this.cards.indexOf(item);
            const selectItem = this.cards[index];

            if(confirm('削除しますか？')) {
                this.cards.splice(index, 1)
                axios
                    .delete("/api/cards/" + selectItem.id)
                    .then(response => {
                        // this.cards = response.data;
                    })
                    .catch(err => {
                        this.message = err;
                    });
            }
        },
        save () {
            // バリデーションチェック
            if(!this.$refs.card_form.validate()) {
                return;
            }

            // レアリティ名などを変換
            this.updateItem = this.converItem(this.updateItem);
            this.updateItem.folder_id = this.folderId;

            if (this.updateId > -1) {
                const cardId = this.cards[this.updateId].id;
                Object.assign(this.cards[this.updateId], this.updateItem);

                axios.put('/api/cards/' + cardId, this.updateItem)
                    .then(response => {
                        console.log('update');
                    }).catch(err => {
                        this.message = err;
                    });
            } else {
                const item = this.updateItem;

                axios.post('/api/cards', this.updateItem)
                    .then(response => {
                        console.log('regist');
                        this.cards.push(response.data);
                    }).catch(err => {
                        this.message = err;
                    });
            }

            this.updateId = -1;
            this.updateItem = this.defaultItem;

            this.close()
        },
        converItem(item) {
            const selectTitle = this.titles.find(({id}) => id == item.titleCd);
            if(selectTitle) {
                item.title = selectTitle.title;
            }

            const selectSymbol = this.symbols.find(({id}) => id == item.symbolCd);
            if(selectSymbol) {
                item.symbol = selectSymbol.name;
                item.symbolColor = selectSymbol.color_code;
            }

            const selectRarity = this.rarities.find(({id}) => id == item.rarityCd);
            if(selectRarity) {
                item.rarity = selectRarity.name;
            }

            return item;
        },
        convertTitle(titleCd) {
            const selectTitle = this.titles.find(({id}) => id == titleCd);

            return selectTitle ? selectTitle.title : null;
        },
        convertRarity(rarityCd) {
            const selectRarity = this.rarities.find(({id}) => id == rarityCd);

            return selectRarity ? selectRarity.name : null;
        },
        convertSymbol(symbolCd) {
            const selectSymbol = this.symbols.find(({id}) => id == symbolCd);

            return selectSymbol ? selectSymbol.name : null;
        },
        convertSymbolColor(symbolCd) {
            const selectSymbol = this.symbols.find(({id}) => id == symbolCd);

            return selectSymbol ? selectSymbol.color_code : null;
        },
        required: value => !!value || "必須入力です",
    }
};
</script>