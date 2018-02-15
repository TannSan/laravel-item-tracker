<template lang="html">
    <div class="demo-content nested">
        <div class="v-row">
            <div v-for="(list, zone) in dropzones" class="v-col--40">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 class="panel-title">Dropzone {{zone}}</h2>
                    </div>
                    <div class="panel-body">
                        <vddl-list class="panel__body--list"
                            :list="list"
                            :inserted="inserted"
                            effect-allowed="move"
                            :disable-if="disable"
                            :external-sources="true">
                            <list v-for="(item, index) in list"
                                :key="item.id"
                                :item="item"
                                :list="list"
                                :index="index"
                                :selected="handleSelected"
                                :selected-item="selectedItem"
                                :disable="disable">
                            </list>
                        </vddl-list>
                    </div>
                </div>
            </div>
      <div class="v-col--20">
        <div class="new-elements">
          <div class="panel panel--info">
            <div class="panel__heading">
              <h3>New Elements</h3>
            </div>
            <div class="panel__body">
              <vddl-draggable class="button"
                :draggable="itemMock"
                :copied="copied"
                effect-allowed="copy">
                Add Item
              </vddl-draggable>
              <br>
              <vddl-draggable class="button"
                :draggable="containerMock"
                :copied="copied"
                effect-allowed="copy">
                Add Container
              </vddl-draggable>
            </div>
          </div>
        </div>
        <div class="new-elements disable-element">
          <div class="panel panel--info">
            <div class="panel__heading">
              <h3>Toggle Disable</h3>
            </div>
            <div class="panel__body">
              <div class="button" @click="toggleDisable">
                Disable: {{disable}}
              </div>
            </div>
          </div>
        </div>
        <div class="selected-item" v-if="selectedItem">
          <div class="panel panel--info">
            <div class="panel__heading">
              <h3>Selected</h3>
            </div>
            <div class="panel__body">
              {{selectedItem.type}} {{selectedItem.id}}
            </div>
          </div>
        </div>
        <div class="ashcan">
          <div class="panel panel--info">
            <div class="panel__heading">
              <h3>Ashcan</h3>
            </div>
            <vddl-list :list="[]" class="panel__body">
              <img class="ashcan-logo" src="/img/ashcan.png" alt="" />
            </vddl-list>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      selectedItem: null,
      itemMock: { type: "new element", id: 1 },
      containerMock: {
        "type": "container",
        "id": 4,
        "columns": []
      },
      disable: false,
      dropzones: {
        "A": [
          {
            "type": "container",
            "id": 1,
            "columns": [
                {
                  "type": "item",
                  "id": "1"
                },
                {
                  "type": "item",
                  "id": "2"
                },
                {
                  "type": "item",
                  "id": "3"
                }
            ]
          },
          {
            "type": "item",
            "id": "4"
          },
          {
            "type": "item",
            "id": "5"
          },
          {
            "type": "item",
            "id": "6"
          }
        ],
        "B": [
          {
            "type": "item",
            "id": 7
          },
          {
            "type": "item",
            "id": "8"
          },
          {
            "type": "container",
            "id": "2",
            "columns": [
                {
                  "type": "item",
                  "id": "9"
                },
                {
                  "type": "item",
                  "id": "10"
                },
                {
                  "type": "container",
                  "id": "3",
                  "columns": [
                      {
                        "type": "item",
                        "id": "13"
                      },
                      {
                        "type": "item",
                        "id": "14"
                      }
                  ]
                },
                {
                  "type": "item",
                  "id": "15"
                }
              ]
            }
          ]
        }
    };
  },
  methods: {
    copied(item){
      item.id++;
    },
    inserted(data){
      console.log(data);
    },
    toggleDisable() {
      this.disable = !this.disable;
    },
    handleSelected(item) {
      this.selectedItem = item;
    }
  }
};
</script>