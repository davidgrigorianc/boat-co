<template>
    <v-app>
        <v-container>
            <v-app-bar app color="primary" dark>
                <v-toolbar-title>Boat Co</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn text to="/">Home</v-btn>
                <v-btn text to="/catalog">Catalog</v-btn>
                <v-btn text to="/about">About</v-btn>
            </v-app-bar>

            <v-main>
                <router-view></router-view>
            </v-main>

            <v-footer color="primary" dark>
                <v-container>
                    <span>&copy; 2025 Boat Co. All rights reserved.</span>
                </v-container>
            </v-footer>
        </v-container>
    </v-app>
</template>

<script>
export default {
    name: "PublicLayout"
};
</script>

<style scoped>
/* Custom styles can be added here */
</style>
