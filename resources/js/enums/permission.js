export const Permission = Object.freeze({
  ALL: 'all',
  TIME_ENTRIES: 'time-entries',
  EDIT_TASK_ANYTIME: 'edit-task-anytime',
  TIME_REPORTS: 'time-reports',
  REPORTS: 'reports',
  PROJECTS: 'projects',
  CLIENTS: 'clients',
  TAGS: 'tags',
  ESTIMATIONS: 'estimations',
  BREAK_EVEN: 'break-even',
  PROJECTS_PROFIT: 'projects-profit',
  SETTINGS: 'settings',
});

export const getEditTaskAnytimePermissions = () => {
  return [Permission.ALL, Permission.EDIT_TASK_ANYTIME];
};
