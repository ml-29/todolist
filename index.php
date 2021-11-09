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
					<input class="task-edit" v-model="task.text" @keyup.enter="onEnter($event.target.value, $event.target.selectionStart, $event.target.selectionEnd, index)" @keyup.delete="onDelete($event.target.selectionStart, index, $event.target.value)" type="text" name="task-edit">
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

			function moveCursor(elem, index){
				if(elem != null && index != null) {
					if(elem.createTextRange) {
						var range = elem.createTextRange();
						range.move('character', index);
						range.select();
					}
					else {
						if(elem.selectionStart) {
							elem.focus();
							elem.setSelectionRange(index, index);
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
						cursor : {
							task : null,
							char : null
						}
					}
				},
				updated(){
					var tEl = document.getElementsByClassName('task-edit');
					moveCursor(tEl[this.cursor.task], this.cursor.char);
				},
				methods : {
					onEnter(value, selstart, selend, index){
						var t1 = value.substring(0, selstart);
						var t2 = value.substring(selend);
						this.tasks[index].text = t1;
						this.tasks.splice(index + 1, 0, {text : t2 , done : false});
						//place cursor at the begining of next line
						this.cursor.task = index + 1;
						this.cursor.char = 0;
					},
					onDelete(selstart, index, value){
						if(selstart == 0 && index != 0){
							this.tasks[index - 1].text += value;
							this.tasks.splice(index, 1);
						}
					}
				}
			});

			app.mount('#todo-list');
		</script>
		<style>
			ul li {
				list-style: none;
			}
			input {border:0;outline:0;}
			input:focus {outline:none!important;}
		</style>
	</body>
</html>
