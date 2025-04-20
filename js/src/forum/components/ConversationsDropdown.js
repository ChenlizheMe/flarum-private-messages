import app from 'flarum/forum/app';
import NotificationsDropdown from 'flarum/forum/components/NotificationsDropdown';
import ConversationsList from './ConversationsList';

export default class ConversationsDropdown extends NotificationsDropdown {
  static initAttrs(attrs) {
    attrs.label ||= app.translator.trans('chenlizheme-private-messages.forum.dropdown.tooltip');
    attrs.icon ||= 'fas fa-comment-alt';
    attrs.className = 'MessagesDropdown NotificationsDropdown';

    super.initAttrs(attrs);
  }

  onclick() {
    if (app.drawer.isOpen()) {
      m.route.set(app.route('conversations'));
    }
  }

  getMenu() {
    return <form className={'Dropdown-menu ' + this.attrs.menuClassName}>{this.showing && <ConversationsList />}</form>;
  }

  getUnreadCount() {
    return app.session.user.unreadMessages();
  }

  getNewCount() {
    return this.getUnreadCount();
  }
}
