// components
function comment() {
	var text = [];

	return {
		oninit: props => {
			for (let i = 0; i < props.attrs.text.length; i++)
				if (props.attrs.text[i] != '\n')
					text[text.length] = props.attrs.text[i];
				else
					text[text.length] = m('br');
		},
		view: props => (
			m('li', [
				m('strong', (props.attrs.name != '') ? props.attrs.name : 'Anonymous'),
				m('br'),
				text.map(element => (element))
			])
		)
	}
}

function commentList() {
	var comments = [];

	return {
		oninit: () => {
			m.request('http://localhost:3333/comments').then(data =>
				data.map(element =>
					comments[comments.length] = m(comment, {
						name: element.name,
						text: element.text
					})
				)
			);
		},
		view: () => (
			m('ul', [
				comments
			])
		)
	}
}

function newComment() {
	const state = {
		// vars
		name: '',
		text: '',
		// functions
		clear: () => {
			state.name = '';
			state.text = '';
		},
		handleInputName: e => state.name = e.target.value,
		handleInputText: e => state.text = e.target.value
	}

	function handleClick() {
		let body = FormData();
		body.append('name', state.name);
		body.append('text', state.text);

		m.request('http://localhost:3333/comments', {
			method: 'POST',
			body: body
		}).then(() => {
			state.clear();
			m.mount(document.getElementById('commentList'), commentList)
		});
	}

	return {
		view: () => (
			m('form', {
				onsubmit: e => e.stopPropagation()
			}, [
				m(`input[type=text][value=${state.name}][placeholder=Anonymous]`, {
					oninput: e => {
						e.stopPropagation();
						state.handleInputName(e);
					}
				}),
				m('textarea', {
					oninput: e => {
						e.stopPropagation();
						state.handleInputText(e);
					}
				}, state.text),
				m('button', {
					onclick: handleClick
				}, 'Comment')
			])
		)
	}
}

// mounts
m.mount(document.getElementById('commentList'), commentList);
m.mount(document.getElementById('newComment'), newComment);