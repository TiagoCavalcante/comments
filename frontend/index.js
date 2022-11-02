// components
function comment() {
  let text = [];

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
  };
}

function commentList() {
  let comments = [];

  return {
    oninit: () => {
      m.request(SERVER).then(data =>
        data.map(element =>
          comments[comments.length] = {
            name: element.name,
            text: element.text
          }
        )
      );
    },
    view: () => (
      m('ul', {
        id: 'commentList'
      }, [
        comments.map(element => (
          m(comment, {
            name: element.name,
            text: element.text
          })
        ))
      ])
    )
  };
}

function newComment() {
  // vars
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
  };

  // functions
  function updateCommentList() {
    let comments = [];

    m.request(SERVER).then(data => {
      data.map(element =>
        comments[comments.length] = {
          name: element.name,
          text: element.text.replace('\n', '<br />')
        }
      );

      for (let i = document.getElementById('commentList').childElementCount; i < comments.length; i++) {
        // vars
        let comment = document.createElement('li');
        let name = document.createElement('strong');

        // TODO
        name.innerHTML = (comments[i].name != '') ? comments[i].name : 'Anonymous';
        comment.appendChild(name);
        comment.innerHTML += `<br />${comments[i].text}`;

        document.getElementById('commentList').appendChild(comment);
      }
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
          onclick: async e => {
            e.preventDefault();

            if (state.name.length <= 32 && state.text.length != 0) {
              try {
                let body = new FormData();
                body.append('name', state.name);
                body.append('text', state.text);

                await m.request(SERVER, {
                  method: 'POST',
                  body: body
                });

                state.clear();

                updateCommentList();
              } catch (error) {
                console.log(error);
                alert(`The error code ${error.code} occurred, try again later`);
              }
            }
            else {
              alert('The text of your comment must be at least 1 letter');
            }
          }
        }, 'Comment')
      ])
    )
  };
}

function main() {
  return {
    view: () => (
      m('main', [
        m(commentList),
        m(newComment)
      ])
    )
  };
}

// mount
m.mount(document.body, main);