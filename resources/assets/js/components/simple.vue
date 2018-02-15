
<template>
    <div id="list-wrapper">
        <div v-for="(list, listName) in lists" class="v-col--auto">
            <div class="panel">
                <div class="panel__heading">
                    <h3>List {{listName}}</h3>
                </div>
                <div class="panel__body">
                    <vddl-list class="panel__body--list" :list="list" :horizontal="false">
                        <vddl-draggable class="panel__body--item" v-for="(item, index) in list" :key="item.id"
                        :draggable="item"
                        :index="index"
                        :wrapper="list"
                        :data-id="item.id"
                        :data-index="index"
                        effect-allowed="move">
                        {{item.label}}
                        </vddl-draggable>
                        <vddl-placeholder class="red">Custom placeholder</vddl-placeholder>
                    </vddl-list>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
          data(){
                return {
                "selected": null,
                "lists": {
                    "A": [
                    {
                        "id": 27,
                        "label": "Item A1"
                    },
                    {
                        "id": 33,
                        "label": "Item A2"
                    },
                    {
                        "label": "Item A3"
                    },
                    {
                        "label": "Item A4"
                    },
                    {
                        "label": "Item A5"
                    }
                    ],
                    "B": [
                    {
                        "label": "Item B1"
                    },
                    {
                        "label": "Item B2"
                    },
                    {
                        "label": "Item B3"
                    },
                    {
                        "label": "Item B4"
                    },
                    {
                        "label": "Item B5"
                    }
                    ],
                    "C": [
                    {
                        "label": "Item C1"
                    },
                    {
                        "label": "Item C2"
                    },
                    {
                        "label": "Item C3"
                    },
                    {
                        "label": "Item C4"
                    },
                    {
                        "label": "Item C5"
                    }
                    ]
                }
                }
            },
            methods: {
                selectedEvent: function(item){
                this.selected = item;
                },
                handleDragstart() {
                console.log(':v-draggable: dragstart');
                },
                handleDragend() {
                console.log(':v-draggable: dragend');
                },
                handleCanceled() {
                console.log(':v-draggable: canceled');
                },
                handleInserted() {
                console.log(':v-list: inserted');
                },
                handleDrop(data) {
                console.log(':v-list: drop');
                console.log(data);
                const { index, list, item } = data;
                list.splice(index, 0, item);
                },
                handleMoved(item) {
                console.log(':v-draggable: moved');
                console.log(item);
                const { index, list } = item;
                list.splice(index, 1);
                },
                handleDragover() {
                console.log(':v-list: handleDragover');
                },
            },
        mounted() {
            console.log('Vddl simple component mounted.')
        }
    }
</script>