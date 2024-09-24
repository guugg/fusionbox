import localForage from 'localforage'

export function configureLocalForage() {
  localForage.config({
    driver: localForage.LOCALSTORAGE,
    name: 'myApp',
    storeName: 'theme',
    description: 'some description'
  })
}
