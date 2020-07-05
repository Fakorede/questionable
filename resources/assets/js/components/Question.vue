<template>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <form
          class="card-body"
          v-if="editing"
          @submit.prevent="update"
        >
          <div class="card-title">
            <input
              type="text"
              name="title"
              class="form-control form-control-lg"
              v-model="title"
            />
          </div>

          <hr />

          <div class="media">
            <div class="media-body">
              <div class="form-group">
                <m-editor :body="body">
                  <textarea
                    name="body"
                    v-model="body"
                    class="form-control"
                    rows="10"
                    required
                  ></textarea>
                </m-editor>
              </div>
              <button
                class="btn btn-sm btn-outline-primary"
                type="submit"
                :disabled="isInvalid"
              >
                Update
              </button>
              <button
                class="btn btn-sm btn-outline-secondary"
                type="button"
                @click="cancel"
              >
                Cancel
              </button>
            </div>
          </div>
        </form>
        <div
          class="card-body"
          v-else
        >
          <div class="card-title">
            <div class="d-flex align-items-center">
              <h1>{{ title }}</h1>
              <div class="ml-auto">
                <a
                  href="/questions"
                  class="btn btn-outline-secondary"
                >
                  Back to all Questions
                </a>
              </div>
            </div>
          </div>

          <hr />

          <div class="media">
            <vote
              :model="question"
              name="question"
            ></vote>

            <div class="media-body">
              <div v-html="bodyHtml"></div>
              <div class="row">
                <div class="col-4">
                  <div class="ml-auto">
                    <a
                      v-if="authorize('modify', question)"
                      @click.prevent="edit"
                      class="btn btn-sm btn-outline-info"
                    >Edit</a>
                    <button
                      v-if="authorize('delete', question)"
                      @click="destroy"
                      class="btn btn-sm btn-outline-danger"
                    >
                      Delete
                    </button>
                  </div>
                </div>
                <div class="col-4"></div>
                <div class="col-4">
                  <user-info
                    :model="question"
                    label="asked"
                  ></user-info>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Vote from "./Vote";
import UserInfo from "./UserInfo";
import MEditor from "./MEditor";
import refactor from "../mixins/refactor";

export default {
  props: ["question"],
  mixins: [refactor],
  data() {
    return {
      title: this.question.title,
      body: this.question.body,
      bodyHtml: this.question.body_html,
      id: this.question.id,
      beforeEditCache: {}
    };
  },
  methods: {
    setEditCache() {
      this.beforeEditCache = {
        title: this.title,
        body: this.body
      };
    },
    restoreFromCache() {
      this.title = this.beforeEditCache.title;
      this.body = this.beforeEditCache.body;
    },
    payload() {
      return {
        title: this.title,
        body: this.body
      };
    },
    delete() {
      axios.delete(this.endpoint).then(({ data }) => {
        this.$toast.success(data.message, "Success", {
          timeout: 1000,
          position: "topRight"
        });
        setTimeout(() => {
          window.location.href = "/questions";
        }, 2000);
      });
    }
  },
  computed: {
    isInvalid() {
      return this.body.length < 10 || this.title.length < 10;
    },
    endpoint() {
      return `/questions/${this.id}/`;
    }
  },
  components: { Vote, UserInfo, MEditor }
};
</script>
