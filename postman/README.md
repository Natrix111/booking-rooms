{
	"info": {
		"_postman_id": "4aaaa374-c296-4670-9dba-df7e48ec9e79",
		"name": "backend",
		"schema": "https://schema.getpostman.com/json/collection/v2.1.0/collection.json",
		"_exporter_id": "26279260"
	},
	"item": [
		{
			"name": "Административные роуты",
			"item": [
				{
					"name": "Изменение контактов",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "M4GID7zeCfC9Xa4tNdOGxSljaSIxtZx284MsKBZM51c63eac",
									"type": "string"
								}
							]
						},
						"method": "PATCH",
						"header": [
							{
								"key": "_method",
								"value": "patch",
								"type": "text"
							}
						],
						"body": {
							"mode": "raw",
							"raw": "{\n    \"email\": \"qwewqd\"\n}",
							"options": {
								"raw": {
									"language": "json"
								}
							}
						},
						"url": {
							"raw": "{{host}}/contact",
							"host": [
								"{{host}}"
							],
							"path": [
								"contact"
							]
						}
					},
					"response": []
				},
				{
					"name": "Изменение info",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "M4GID7zeCfC9Xa4tNdOGxSljaSIxtZx284MsKBZM51c63eac",
									"type": "string"
								}
							]
						},
						"method": "PATCH",
						"header": [],
						"body": {
							"mode": "raw",
							"raw": "{\n    \"title\": \"Новый заголовок\",\n    \"slogan\": \"Новый слоган\",\n    \"city\":\"Питер\"\n}",
							"options": {
								"raw": {
									"language": "json"
								}
							}
						},
						"url": {
							"raw": "{{host}}/info",
							"host": [
								"{{host}}"
							],
							"path": [
								"info"
							]
						}
					},
					"response": []
				},
				{
					"name": "Список удобств",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "M4GID7zeCfC9Xa4tNdOGxSljaSIxtZx284MsKBZM51c63eac",
									"type": "string"
								}
							]
						},
						"method": "GET",
						"header": [],
						"url": {
							"raw": "{{host}}/amentities",
							"host": [
								"{{host}}"
							],
							"path": [
								"amentities"
							]
						}
					},
					"response": []
				},
				{
					"name": "Добавление нововго удобства",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "bkaHLvtRGoNJnrjqeqoiPfWOFpsSskCwzB6LeQcL8d6c68f3",
									"type": "string"
								}
							]
						},
						"method": "POST",
						"header": [],
						"body": {
							"mode": "formdata",
							"formdata": [
								{
									"key": "name",
									"value": "Телик",
									"type": "text"
								},
								{
									"key": "img",
									"contentType": "",
									"type": "file",
									"src": "/home/yoru/Desktop/images/ebf7fc25cf73d2e65f1391735034dc6d.jpg"
								}
							]
						},
						"url": {
							"raw": "{{host}}/amentities",
							"host": [
								"{{host}}"
							],
							"path": [
								"amentities"
							]
						}
					},
					"response": []
				},
				{
					"name": "Изменение удобства",
					"protocolProfileBehavior": {
						"disabledSystemHeaders": {}
					},
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "bkaHLvtRGoNJnrjqeqoiPfWOFpsSskCwzB6LeQcL8d6c68f3",
									"type": "string"
								}
							]
						},
						"method": "POST",
						"header": [
							{
								"key": "_method",
								"value": "patch",
								"type": "text"
							}
						],
						"body": {
							"mode": "formdata",
							"formdata": [
								{
									"key": "name",
									"value": "телевизорр",
									"type": "text"
								},
								{
									"key": "img",
									"type": "file",
									"src": "/home/yoru/Desktop/images/gostevaya.jpg"
								}
							]
						},
						"url": {
							"raw": "{{host}}/amentities/6?_method=patch",
							"host": [
								"{{host}}"
							],
							"path": [
								"amentities",
								"6"
							],
							"query": [
								{
									"key": "_method",
									"value": "patch"
								}
							]
						}
					},
					"response": []
				},
				{
					"name": "Удаление удобства",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "HqMQy64qcd3cVv65NMK8d3zhwoHgZ2Gh9XQmkqgEf66b94a2",
									"type": "string"
								}
							]
						},
						"method": "DELETE",
						"header": [],
						"url": {
							"raw": "{{host}}/amentities/5",
							"host": [
								"{{host}}"
							],
							"path": [
								"amentities",
								"5"
							]
						}
					},
					"response": []
				},
				{
					"name": "Создание номера",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "M4GID7zeCfC9Xa4tNdOGxSljaSIxtZx284MsKBZM51c63eac",
									"type": "string"
								}
							]
						},
						"method": "POST",
						"header": [],
						"body": {
							"mode": "formdata",
							"formdata": [
								{
									"key": "name",
									"value": "Номер 1",
									"type": "text"
								},
								{
									"key": "amenities[0]",
									"value": "7",
									"type": "text"
								},
								{
									"key": "price",
									"value": "9000",
									"type": "text"
								},
								{
									"key": "photos[0]",
									"type": "file",
									"src": "/home/yoru/Desktop/images/238862_childrens-room_1-min.jpg"
								},
								{
									"key": "featured",
									"value": "0",
									"type": "text"
								},
								{
									"key": "amenities[1]",
									"value": "955",
									"type": "text"
								},
								{
									"key": "width",
									"value": "5",
									"type": "text"
								},
								{
									"key": "height",
									"value": "5",
									"type": "text"
								},
								{
									"key": "length",
									"value": "5",
									"type": "text"
								},
								{
									"key": "photos[1]",
									"type": "file",
									"src": "/home/yoru/Desktop/images/gostevaya.jpg"
								}
							]
						},
						"url": {
							"raw": "{{host}}/rooms",
							"host": [
								"{{host}}"
							],
							"path": [
								"rooms"
							]
						}
					},
					"response": []
				},
				{
					"name": "Редактирование номера",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "M4GID7zeCfC9Xa4tNdOGxSljaSIxtZx284MsKBZM51c63eac",
									"type": "string"
								}
							]
						},
						"method": "POST",
						"header": [
							{
								"key": "_method",
								"value": "patch",
								"type": "text"
							}
						],
						"body": {
							"mode": "formdata",
							"formdata": [
								{
									"key": "name",
									"value": "Номер 6",
									"type": "text"
								},
								{
									"key": "amenities[0]",
									"value": "8",
									"type": "text"
								},
								{
									"key": "price",
									"value": "9000",
									"type": "text"
								},
								{
									"key": "photos[0]",
									"type": "file",
									"src": "/home/yoru/Desktop/images/gostevaya.jpg"
								},
								{
									"key": "featured",
									"value": "0",
									"type": "text"
								},
								{
									"key": "amenities[1]",
									"value": "5",
									"type": "text",
									"disabled": true
								},
								{
									"key": "width",
									"value": "54",
									"type": "text"
								},
								{
									"key": "height",
									"value": "55",
									"type": "text"
								},
								{
									"key": "length",
									"value": "58",
									"type": "text"
								},
								{
									"key": "photos[1]",
									"type": "file",
									"src": [],
									"disabled": true
								}
							]
						},
						"url": {
							"raw": "{{host}}/rooms/1?_method=patch",
							"host": [
								"{{host}}"
							],
							"path": [
								"rooms",
								"1"
							],
							"query": [
								{
									"key": "_method",
									"value": "patch"
								}
							]
						}
					},
					"response": []
				},
				{
					"name": "Удаление номера",
					"request": {
						"auth": {
							"type": "bearer",
							"bearer": [
								{
									"key": "token",
									"value": "HqMQy64qcd3cVv65NMK8d3zhwoHgZ2Gh9XQmkqgEf66b94a2",
									"type": "string"
								}
							]
						},
						"method": "DELETE",
						"header": [],
						"body": {
							"mode": "formdata",
							"formdata": [
								{
									"key": "name",
									"value": "Номер 1",
									"type": "text"
								},
								{
									"key": "dimensions",
									"value": "",
									"type": "text"
								}
							]
						},
						"url": {
							"raw": "{{host}}/rooms/32",
							"host": [
								"{{host}}"
							],
							"path": [
								"rooms",
								"32"
							]
						}
					},
					"response": []
				}
			]
		},
		{
			"name": "регистрация",
			"request": {
				"method": "POST",
				"header": [],
				"body": {
					"mode": "raw",
					"raw": "{\n    \"name\":\"Имя\",\n    \"phone\":\"+7(999)999-99-99\",\n    \"email\":\"John@John\",\n    \"password\":\"12345678\"\n\n}",
					"options": {
						"raw": {
							"language": "json"
						}
					}
				},
				"url": {
					"raw": "{{host}}/register",
					"host": [
						"{{host}}"
					],
					"path": [
						"register"
					]
				}
			},
			"response": []
		},
		{
			"name": "информация о пользователе",
			"request": {
				"auth": {
					"type": "bearer",
					"bearer": [
						{
							"key": "token",
							"value": "iwKLOaaDPwBYtShYmJgrUBAsY2f7UQ4Jh06vepDbd10d4690",
							"type": "string"
						}
					]
				},
				"method": "GET",
				"header": [],
				"url": {
					"raw": "{{host}}/user",
					"host": [
						"{{host}}"
					],
					"path": [
						"user"
					]
				}
			},
			"response": []
		},
		{
			"name": "login",
			"request": {
				"method": "POST",
				"header": [],
				"body": {
					"mode": "raw",
					"raw": "{\n    \"email\":\"Admin@admin.com\",\n    \"password\":\"superAdmin\"\n}",
					"options": {
						"raw": {
							"language": "json"
						}
					}
				},
				"url": {
					"raw": "{{host}}/login",
					"host": [
						"{{host}}"
					],
					"path": [
						"login"
					]
				}
			},
			"response": []
		},
		{
			"name": "показ контактов",
			"protocolProfileBehavior": {
				"disableBodyPruning": true
			},
			"request": {
				"method": "GET",
				"header": [],
				"body": {
					"mode": "raw",
					"raw": "",
					"options": {
						"raw": {
							"language": "json"
						}
					}
				},
				"url": {
					"raw": "{{host}}/contact",
					"host": [
						"{{host}}"
					],
					"path": [
						"contact"
					]
				}
			},
			"response": []
		},
		{
			"name": "показ info",
			"request": {
				"method": "GET",
				"header": [],
				"url": {
					"raw": "{{host}}/info",
					"host": [
						"{{host}}"
					],
					"path": [
						"info"
					]
				}
			},
			"response": []
		},
		{
			"name": "случайные отзывы",
			"request": {
				"method": "GET",
				"header": [],
				"url": {
					"raw": "{{host}}/reviews",
					"host": [
						"{{host}}"
					],
					"path": [
						"reviews"
					]
				}
			},
			"response": []
		},
		{
			"name": "список номеров",
			"request": {
				"auth": {
					"type": "noauth"
				},
				"method": "GET",
				"header": [],
				"url": {
					"raw": "{{host}}/rooms",
					"host": [
						"{{host}}"
					],
					"path": [
						"rooms"
					]
				}
			},
			"response": []
		},
		{
			"name": "Просмотр изображений",
			"request": {
				"method": "GET",
				"header": [],
				"url": {
					"raw": "{{host}}/images/674f32e3104ab.jpg",
					"host": [
						"{{host}}"
					],
					"path": [
						"images",
						"674f32e3104ab.jpg"
					]
				}
			},
			"response": []
		}
	],
	"event": [
		{
			"listen": "prerequest",
			"script": {
				"type": "text/javascript",
				"packages": {},
				"exec": [
					""
				]
			}
		},
		{
			"listen": "test",
			"script": {
				"type": "text/javascript",
				"packages": {},
				"exec": [
					""
				]
			}
		}
	],
	"variable": [
		{
			"key": "host",
			"value": "127.0.0.1:8080/api",
			"type": "string"
		}
	]
}