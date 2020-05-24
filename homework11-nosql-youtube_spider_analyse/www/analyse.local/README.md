# Analyse NoSQL App

## Выборка наиболее подходящего событие по params

- uri: /events
- method: GET
- body: raw json (params)

```json
	{
		"params" : {
			"report": "main",
			"param": 7
		}
	}
```

## Добавления события в систему

- uri: /event/add
- method: GET
- body: raw json

```json
	{
		"priority": 5400,
		"conditions": {
			"report": "main",
			"param": 7
		},
		"event": {
			"demo_report": "30.05.2020"
		}
	}
```

## Очистка всех доступны событий

- uri: /event/delete
- method: DELETE
