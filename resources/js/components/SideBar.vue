<template>
    <v-app>
        <v-list>
            <v-list-item-group>
                <v-list-item
                    v-for="(item, i) in links"
                    :key="i"
                >
                    <v-list-item-icon>
                        <v-icon v-text="item.icon"></v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <router-link :to="{ name: item.href }">
                            <v-list-item-title v-text="item.name"></v-list-item-title>
                        </router-link>
                    </v-list-item-content>
                </v-list-item>
            </v-list-item-group>
        </v-list>
    </v-app>
</template>

<script>
    export default {
        data() {
            return {
                links: [
                    {
                        name: 'ホーム',
                        href: 'list',
                        icon: 'mdi-home',
                    },
                    {
                        name: 'フォルダー一覧',
                        href: 'folder',
                        icon: 'mdi-folder',
                    }
                ]
            };
        }
    }
</script>
