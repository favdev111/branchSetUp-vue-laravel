<template>
    <div class="main-background">
        <div class="container form-background">
            <a href="#" class="float-right" @click="logout">Logout</a>

            <ul class="nav nav-tabs mb-2">
                <li class="nav-item">
                    <a href="#" class="nav-link" :class="{'active': activeTab === 'branch'}" @click.prevent="activeTab = 'branch'">Branch Setup</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" :class="{disabled: !branchFilled, 'active': activeTab === 'employees-list'}" @click.prevent="activeTab = 'employees-list'">Employees</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" :class="{disabled: !branchFilled, 'active': activeTab === 'technicians-list'}" @click.prevent="activeTab = 'technicians-list'">Technicians</a>
                </li>
            </ul>

            <component :is="activeTab"/>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                activeTab: 'branch',
                tabs: [
                    'branch',
                    'employees-list',
                    'technicians-list',
                ]
            }
        },
        computed: {
            branchFilled() {
                return (this.$store.state.branch.branch_name || this.$store.state.saved);
            }
        },

        methods: {
            logout(event) {
                event.preventDefault();
                document.getElementById('logout-form').submit();
            }
        }
    }
</script>