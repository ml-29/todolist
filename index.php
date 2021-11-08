<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<title>To-do list with vue</title>
		<script src="https://unpkg.com/vue@next"></script>
		<script src="https://kit.fontawesome.com/739b8fcf94.js" crossorigin="anonymous"></script>
	</head>
	<body>
		<div id="todo-list">
			<ul>
				<li v-for="(task, index) in tasks" :key="index">
					<i @click="task.done = !task.done" v-bind:class="{ 'far fa-square': !task.done, 'far fa-check-square': task.done }"></i>
					<!-- <span @keyup.enter="addTaskAfter($event, index, task)" @keyup.delete="removeTaskBefore($event, index)">{{ task.text }}</span> -->
					<!-- <span v-if="editing.index != index" @click="toggleEdit(index)">{{ task.text }}</span> -->
					<input @keyup.enter="splitTask($event.target.value, $event.target.selectionStart, index)" @keyup="renameTask(index, $event.target.value)" type="text" name="task-edit" v-bind:value="task.text">
				</li>
			</ul>
		</div>

		<script>
			function getCaretPosition(editableDiv) {
				var caretPos = 0,
				sel, range;
				if (window.getSelection) {
					sel = window.getSelection();
					if (sel.rangeCount) {
						range = sel.getRangeAt(0);
						if (range.commonAncestorContainer.parentNode == editableDiv) {
							caretPos = range.endOffset;
						}
					}
				} else if (document.selection && document.selection.createRange) {
					range = document.selection.createRange();
					if (range.parentElement() == editableDiv) {
						var tempEl = document.createElement("span");
						editableDiv.insertBefore(tempEl, editableDiv.firstChild);
						var tempRange = range.duplicate();
						tempRange.moveToElementText(tempEl);
						tempRange.setEndPoint("EndToEnd", range);
						caretPos = tempRange.text.length;
					}
				}
				return caretPos;
			}

			//BUG : pressing suppr while editing doesn't do anything
			// TODO : place cursor where it should be when editing

			function moveCursor(elem, index){
				if(elem != null && index != null) {
					if(elem.createTextRange) {
						var range = elem.createTextRange();
						range.move('character', caretPos);
						range.select();
					}
					else {
						if(elem.selectionStart) {
							elem.focus();
							elem.setSelectionRange(caretPos, caretPos);
						}else{
							elem.focus();
						}
					}
				}
			}

			const app = Vue.createApp({
				data() {
					return {
						tasks : [
							{ text: 'Learn JavaScript', done : false },
							{ text: 'Learn Vue', done : true },
							{ text: 'Build something awesome', done : false}
						],
						editing : {
							index : null,
							charAt : null
						}
					}
				},
				changed(){
					var tEl = document.getElementsByClassName('task-edit');
					moveCursor(tEl[this.cursorPos.taskIndex], this.cursorPos.charAt);
				},
				methods : {
					splitTask(value, charat, index){
						var t1 = value.substring(0, charat);
						var t2 = value.substring(charat);
						this.tasks[index].text = t1;
						this.tasks.splice(index + 1, 0, {text : t2 , done : false});
					},
					removeTaskBefore(evt, index){
						// if there's nothing before cursor and there's a task before the current one
						// var i = index - 1;
						// var b = getCaretPosition(evt.target);
						// if(i > 0 && b.length == 0){
						// 	this.tasks.splice(i, 1);
						// }
					},
					// renameTask(evt, index){
					// 	this.tasks[index].text = evt.target.innerText;
					// 	this.cursorPos.taskIndex = index;
					// 	this.cursorPos.charAt = evt.target.innerText.length - 1;
					// },
					renameTask(key, value){
						this.tasks[key].text = value;
					},
					updateSkillObject(value, key) {
				      this.tasks[key].text = value;
				      console.log(this.tasks);
				    },
				}
			});

			app.mount('#todo-list');
		</script>
		<style>
			ul li {
				list-style: none;
			}
			/* input {
				border: none;
			} */
		</style>
	</body>
</html>
