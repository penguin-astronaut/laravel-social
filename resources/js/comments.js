const loadCommentsButton = document.querySelector('.load-comments');
const commentsContainer = document.querySelector('.comments');

document.addEventListener('click', (e) => {
    if (e.target.classList.contains('reply-comment')) {
        renderReplyForm(e.target);
    }
})

window.replyFormSubmit = async function (e) {
    e.preventDefault();
    const form = e.target.closest('form');
    form.querySelector('.form-errors').innerHTML = '';
    const data = new FormData(form);
    const fields = Object.fromEntries(data.entries());
    fields._token = window.secureToken;

    const response = await fetch('/comment/create', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: "include",
        body: JSON.stringify(fields)
    })

    if (response.ok) {
       return location.reload();
    }

    renderFormErrors(form, await response.json())
}

function renderFormErrors(form, responseJson) {
    const errorsContainer = form.querySelector('.form-errors');
    const errors = responseJson.errors;
    for (let key in errors) {
        const errorMessage = `<p class="text-danger">${errors[key]}</p>`;
        errorsContainer.insertAdjacentHTML('beforeend', errorMessage)
    }
}

function renderReplyForm(targetButton) {
    const user = targetButton.dataset.user;
    const commentId = targetButton.dataset.commentId;

    const form = `
         <form class="m-3 p-2 border rounded reply-comment-form" onsubmit="replyFormSubmit(event)">
            <p>You are replying to a comment by <strong>${user}</strong></p>
            <div class="form-errors"></div>
            <div class="form-group">
                <label for="title">Title</label>
                <input id="title" name="title" type="text" class="form-control">
            </div>
            <div class="form-group">
                <label for="text">Comment</label>
                <textarea id="text" name="text" class="form-control"></textarea>
            </div>
            <input type="hidden" name="recipient_id" value="${window.ownerId}">
            <input type="hidden" name="parent_id" value="${commentId}">
            <button class="btn btn-primary mt-3">Send</button>
        </form>
    `

    targetButton.closest('.comment').insertAdjacentHTML('beforeend',form);
}

function renderComments(comments) {
    comments.map((comment) => {
        const commentHeader = `
            <div class="d-flex align-items-center">
                <p class="mr-1"><strong>${comment.title}</strong></p>
                <p class="text-secondary small mr-1">User: ${comment.user.email}</p>
                <p class="text-secondary small">Date: ${formatDate(comment.created_at)}</p>
            </div>
        `

        let commentBody = '';
        if (comment.parent_id) {
            commentBody = `
                <blockquote class="blockquote">
                    <p class="fst-italic">&laquo;${comment.parent ? comment.parent.text : 'Comment is deleted'}&raquo;</p>
                </blockquote>`
        }
        commentBody += `<p>${comment.text}</p>`

        const commentContent = `<div class="flex-column">${commentHeader}${commentBody}</div>`

        let deleteButton = '';
        if (comment.user.id === window.authId || window.authId === window.ownerId) {
            deleteButton += ` <a class="btn btn-danger" href="/comment/delete/${comment.id}">Delete</a>`
        }
        const buttons = `<div class="d-flex">
            <button
                class="btn btn-primary d-block mr-1 reply-comment"
                data-user="${comment.user.name}"
                data-comment-id="${comment.id}"
            >
                Reply
            </button>
            ${deleteButton}
        </div>`

        const item = `<div class="comment">${commentContent}${buttons}</div>`

        commentsContainer.insertAdjacentHTML('beforeend', item);
    })
}


function formatDate(date) {
    let d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear(),
        hours = d.getHours(),
        min = d.getMinutes();

    month = month.length < 2 ? '0' + month : month;
    day = day.length < 2 ? '0' + day : day;
    hours = hours.length < 2 ? '0' + hours : hours;
    min = min.length < 2 ? '0' + min : min;

    return `${day}.${month}.${year} ${hours}:${min}`;
}

loadCommentsButton &&
loadCommentsButton.addEventListener('click', () => {
    fetch('/comment/load', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({'recipient_id': window.ownerId, _token: window.secureToken})
    })
        .then((response) => response.json())
        .then((data) => {
            renderComments(data.comments);
            loadCommentsButton.remove();
        })
})
