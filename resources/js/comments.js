const loadCommentsButton = document.querySelector('.load-comments');
const commentsContainer = document.querySelector('.comments');

function renderComments(comments) {
    comments.map((comment) => {
        let item = `
            <div class="flex-column">
                <div class="d-flex align-items-center">
                    <p class="mr-1"><strong>${comment.title}</strong></p>
                    <p class="text-secondary small mr-1">User: ${comment.user.email}</p>
                    <p class="text-secondary small">Date: ${formatDate(comment.created_at)}</p>
                </div>

                <p>${comment.text}</p>
            </div>
        `
        console.log(comment.user.id)
        console.log(window.authId)
        console.log(window.ownerId)
        if (comment.user.id === window.authId || window.authId === window.ownerId) {
            item += ` <a class="btn btn-danger" href="/comment/delete/${comment.id}">Delete</a>`
        }
        item += '<hr>';
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


