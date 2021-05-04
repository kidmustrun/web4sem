{
  viewer {
    login,
    name, 
    url
    repositories(first: 10) {
      nodes {
        name
        description
        createdAt
        url
        issues(states: OPEN) {
          totalCount
        }
      }
    }
  }
}



mutation CreateRepository {
  createRepository(input: {visibility: PRIVATE, name: "hw5"}) {
    repository {
      name, id
    }
  }
}


mutation CreateIssue {
  createIssue(input: {repositoryId: "MDEwOlJlcG9zaXRvcnkzNjE3MDM2Nzc=", title: "TestIssue", body: "issue created"}) {
    issue {
      number
      body
      id
    }
  }
}


mutation UpdateIssue {
  updateIssue(input: {id: "MDU6SXNzdWU4Njc1Mjk4MjA=", title: "Updated issue", body: "ussue update"}) {
    issue {
      number
      body
      id
    }
  }
}


mutation CloseIssue {
  closeIssue(input: {issueId: "MDU6SXNzdWU4Njc1Mjk4MjA="}) {
    clientMutationId
  }
}


Авторизация
Ввод номера телефона - аутентификация при помощи кода, присланного на телефон - успешная авторизация либо новая попытка.
Передается {phone: "79206474004"} в request payload, метод выбран post, Request URL: https://youla.ru/web-api/auth/request_code, Remote Address: 217.69.139.20:443, Content-Type: application/json. 


В ответ от сервера приходит {"phone":"79206474004","code_length":6,"use_callui":false}, где code_length - будущая длина кода для входа. 


После авторизации запросы, например, к сообщениям, имеют заголовки authorization (по токену), а также поля user_id в передаваемых параметрах.