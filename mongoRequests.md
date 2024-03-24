### Request for completed tasks for the selected project on the specified date:

```js
db.tasks.find(
    {
        project: "Website Development",
        end_time: {
            $lt: new Date("2024-03-23T00:00:00Z").getTime() / 1000,
        },
    },
    { _id: 0 },
);
```

### The number of projects of the specified manager:

```js
db.projects.count({
    manager: "Jane Smith",
});
```

### Employees who worked under the leadership of the elected manager:

```js
db.tasks.distinct(
    "workers",
    {
        manager: "Jane Smith",
    },
    { _id: 0 },
);
```
