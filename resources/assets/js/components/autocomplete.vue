<template>
  <div class="autocomplete">
    <input
    type="text"
    v-model="search"
    @input="onChange"
    @keydown.down="onArrowDown"
    @keydown.up="onArrowUp"
    @keydown.enter="onEnter"
    />
    <ul
      id="autocomplete-results"
      v-show="isOpen"
      class="autocomplete-results"
    >
      <li
        class="loading"
        v-if="isLoading">
        Loading results...
      </li>
      <li
        v-else
        v-for="(result, i) in results"
        :key="i"
        @click="setResult(result)"
        class="autocomplete-result"
        :class="{ 'is-active': i === arrowCounter }"
      >
      {{ result }}
      </li>
    </ul>
  </div>
</template>

<style>
  .autocomplete {
    position: relative;
    width: 330px;
  }

  .autocomplete-results {
    padding: 0;
    margin: 0;
    border: 1px solid #eeeeee;
    height: 120px;
    overflow: auto;
  }

  .autocomplete-result {
    list-style: none;
    text-align: left;
    padding: 4px 2px;
    cursor: pointer;
  }

  .autocomplete-result:hover {
    background-color: #4AAE9B;
    color: white;
  }
  
  .autocomplete-result.is-active,
  .autocomplete-result:hover {
    background-color: #4AAE9B;
    color: white;
  }
</style>

<script>
  export default {
    name: 'autocomplete',
    props: {
      items: {
        type: Array,
        required: false,
        default: () => [],
      },
      isAsync: {
        type: Boolean,
        required: false,
        default: false,
      },
    },
    data() {
      return {
        isOpen: false,
        results: [],
        search: '',
        isLoading: false,
        arrowCounter: -1,
      };
    },
    methods: {
      onChange() {
        // Let's warn the parent that a change was made
        this.$emit('input', this.search);

        // Is the data given by an outside ajax request?
        if (this.isAsync) {
          this.isLoading = true;
        } else {
          // Data is sync, we can search our flat array
          this.filterResults();
          this.isOpen = true;
        }
      },
      filterResults() {
        // first uncapitalize all the things
        this.results = this.items.filter((item) => {
          return item.toLowerCase().indexOf(this.search.toLowerCase()) > -1;
        });
      },
      setResult(result) {
        this.search = result;
        this.isOpen = false;
      },
      onArrowDown() {
        if (this.arrowCounter < this.results.length) {
          this.arrowCounter = this.arrowCounter + 1;
        }
      },
      onArrowUp() {
        if (this.arrowCounter > 0) {
          this.arrowCounter = this.arrowCounter - 1;
        }
      },
      onEnter() {
        this.search = this.results[this.arrowCounter];
        this.isOpen = false;
        this.arrowCounter = -1;
      },
      handleClickOutside(evt) {
        if (!this.$el.contains(evt.target)) {
            this.isOpen = false;
            this.arrowCounter = -1;
        }
      }
    },
    watch: {
      // Once the items content changes, it means the parent component
      // provided the needed data
      items: function (value, oldValue) {
        // we want to make sure we only do this when it's an async request
        if (this.isAsync) {
          this.results = value;
          this.isOpen = true;
          this.isLoading = false;
        }
      }
    },
    mounted() {
        document.addEventListener('click', this.handleClickOutside);
    },
    destroyed() {
        document.removeEventListener('click', this.handleClickOutside);
    }
  }
</script>