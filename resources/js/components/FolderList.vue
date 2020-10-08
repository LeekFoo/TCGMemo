<template>
    <v-app id="card-list">
        <v-card>
            <v-card-title>
                フォルダー一覧
                <v-spacer></v-spacer>
                <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="フォルダー名"
                    single-line
                    hide-details
                ></v-text-field>
            </v-card-title>
            <div class="col-sm-12">
                <v-data-table
                    :headers="headers"
                    :items="folders"
                    :page.sync="page"
                    :items-per-page="itemsPerPage"
                    :total-visible="totalVisible"
                    :search="search"
                    hide-default-footer
                    @page-count="pageCount = $event"
                >
                    <template v-slot:item.name="{ item }">
                        <router-link :to="{ name: 'folderCardList', params: { folderId: item.id } }">{{ item.name }}</router-link>
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
                    フォルダーを追加
                </v-btn>
            </template>
            <v-card>
                <v-card-title>
                    <span class="headline">{{ formTitle }}</span>
                </v-card-title>

                <v-card-text>
                    <v-container>
                    <v-row>
                        <v-form ref="folder_form">
                            <v-col
                                cols="12"
                            >
                            <v-text-field
                                v-model="updateItem.name"
                                label="フォルダー名"
                                :rules="[required]"
                            ></v-text-field>
                            </v-col>
                        </v-form>
                    </v-row>
                    </v-container>
                </v-card-text>

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
    data() {
        return {
            headers: [
                {
                    text: 'ID',
                    value: 'id'
                },
                {
                    text: config.folderName,
                    value: 'name',
                },

                // { text: 'カード数',
                //     value: 'amount'
                // },
                { text: '操作',
                    value: 'actions',
                    sortable: false
                },
            ],
            message: "",
            folders: [],
            search: null,
            dialog: false,
            page: 1,
            pageCount: 0,
            itemsPerPage: 20,
            totalVisible: 7,
            updateId: -1,
            updateItem: {
                id: null,
                folder_id: null,
                name: null,
            },
            defaultItem: {
                id: null,
                folder_id: null,
                name: null,
            }
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
            this.getFolder();
        },
        getFolder() {
            axios
                .get("/api/folders/")
                .then(response => {
                    this.folders = response.data;
                })
                .catch(err => {
                    this.message = err;
                });
        },
        editItem (item) {
            this.updateId = this.folders.indexOf(item)
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
            const index = this.folders.indexOf(item);
            const selectItem = this.folders[index];

            if(confirm('削除しますか？')) {
                axios
                    .delete("/api/folders/" + selectItem.id)
                    .then(response => {
                        this.folders.splice(index, 1);
                    })
                    .catch(err => {
                        this.message = err;
                    });
            }
        },
        save () {
            // カード名が入力されていない場合は保存しない
            // if (!this.updateItem.name) {
            //     this.updateItem = this.defaultItem;
            //     this.close();
            //     return;
            // }

            // バリデーションチェック
            if(!this.$refs.folder_form.validate()) {
                return;
            }

            this.updateItem.folder_id = this.folderId;

            if (this.updateId > -1) {
                const folderId = this.folders[this.updateId].id;
                Object.assign(this.folders[this.updateId], this.updateItem);

                axios.put('/api/folders/' + folderId, this.updateItem)
                    .then(response => {
                        console.log('update');
                    }).catch(err => {
                        this.message = err;
                    });
            } else {
                const item = this.updateItem;

                axios.post('/api/folders', this.updateItem)
                    .then(response => {
                        console.log('regist');
                        this.folders.push(response.data);
                    }).catch(err => {
                        this.message = err;
                    });
            }

            this.updateId = -1;
            this.updateItem = this.defaultItem;

            this.close()
        },
        required: value => !!value || "必須入力です",
    }
};
</script>