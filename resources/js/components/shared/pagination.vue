<template>
	<div class="d-inline-block pagination-container" v-if="pagination.pages && Object.keys(pagination.pages).length > 1">
		<ul class="pagination mb-0 border" :class="{'pagination-limit' : pagination_left_items || pagination_right_items}" v-if="pagination.pages">
		    <li class="page-item" :class="{disabled: current_page == 1}">
		    	<span class="page-link cursor-pointer" @click="paginate(pagination.pages[current_page - 1], current_page - 1)"><i class="far fa-arrow-left"></i></span>
		    </li>

		    <template v-if="pagination_left_items">
			    <li class="page-item side-item">
			    	<span class="page-link cursor-pointer" @click="paginate(pagination.pages[1], 1)">1</span>
			    </li>
		    	<li class="page-item disabled side-item">
		    		<span class="page-link px-1">...</span>
		    	</li>
		    </template>

		    <li class="page-item" :class="[index == current_page ? 'active' : 'cursor-pointer']" v-for="(page, index) in pages">
		    	<span class="page-link" @click="paginate(page, index)">{{ index }}</span>
		    </li>


		    <template v-if="pagination_right_items">
		    	<li class="page-item disabled side-item">
		    		<span class="page-link px-1">...</span>
		    	</li>
			    <li class="page-item side-item">
			    	<span class="page-link cursor-pointer" @click="paginate(pagination.pages[pagination.last_page], pagination.last_page)">{{ pagination.last_page }}</span>
			    </li>
		    </template>

		    <li class="page-item" :class="{disabled: current_page == pagination.last_page}">
		    	<span class="page-link cursor-pointer" @click="paginate(pagination.pages[current_page + 1], current_page + 1)"><i class="far fa-arrow-right"></i></span>
		    </li>
		</ul>
	</div>
</template>

<script>
    export default {
    	props: {
    		pagination: {
                required: true,
    			type: [Object, Array],
    			default: []
    		},
    		current_page: {
                required: true,
    			type: [String, Number],
    			default: 1
    		},
    		limit: {
    			type: Number,
    			default: 5
    		}
    	},

        computed: {
        	pagination_left_items() {
        		return this.pagination.last_page > 1 && this.current_page >= this.limit;
        	},

        	pagination_right_items() {
        		return this.current_page < this.pagination.last_page - 2;
        	},

        	pages() {
        		var pagination_pages = this.pagination.pages;
        		var pages = [];
        		var first_limit = Math.floor(this.limit / 2);
        		var last_limit = first_limit;

        		var page_diff = this.pagination.last_page - this.current_page;
        		if (page_diff <= 1){
        			first_limit = first_limit + (page_diff == 1 ? 1 : 2);
        		}
        		if (this.current_page <= last_limit) {
        			last_limit = this.limit - this.current_page;
        		}

    			pages = Object.keys(pagination_pages)
        			.filter(key => 
        				key >= this.current_page - first_limit && 
        				key <= this.current_page + last_limit
        			)
				  	.reduce((obj, key) => {
				    	obj[key] = pagination_pages[key];
				    	return obj;
				  	}, {});


        		return pages;
        	}
        },

        methods: {
        	paginate(url, page) {
        		if (page != this.current_page) {
        			this.$emit('change', url, page);
        		}
        	},

        	show(index) {
        		return index <= this.limit;
        	}
        }
    }
</script>