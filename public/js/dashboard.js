

const textList = {};

var deletingSomething = false;

var csrf_token = '';

function init() {
    csrf_token = document.getElementById('csrf_token').getAttribute('value');
    document.querySelectorAll('*').forEach (
        function (tag) {
            if (tag.hasAttribute('data-bs-target') && tag.hasAttribute('modal-replacers') && tag.hasAttribute('taskid'))
            {
                let target = document.querySelector(tag.getAttribute('data-bs-target'));
                let replacers = tag.getAttribute('modal-replacers').split(',');
                let taskid = tag.getAttribute('taskid');
                tag.addEventListener('click', function (event) {
                    target.querySelectorAll('*').forEach(
                        function (element) {
                            if (element.hasAttribute('model-text'))
                            {
                                let modelText = element.getAttribute('model-text');
                                for (let text of replacers)
                                {
                                    let textSplited = text.split(':');
                                    modelText = modelText.replaceAll('{' + textSplited[0] + '}', textSplited[1]);
                                }
                                element.textContent = modelText;
                                let targetButton = target.querySelector('button[confirmation]');
                                targetButton.setAttribute('taskid', taskid);
                            }
                        }
                    )
                });
            }
        }
    );
}


async function deleteTask(id, url) {
    if (!deletingSomething)
    {
        deletingSomething = true;
        const response = await fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrf_token,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                id: id
            })
        });
        let responseText = await response.text();
        console.log(responseText);
        if (responseText == '1')
        {
            window.location.href = window.location.href;
        } else {
            deletingSomething = false;
        }
    }
}

async function checkTask(id, url) {
    const response = await fetch(url + id, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': csrf_token
        }
    });
    const textResponse = await response.text();
    console.log(textResponse);
    if (textResponse == '1')
    {
        window.location.href = window.location.href;
    }
}

init();