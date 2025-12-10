#include "ems.h"

User users[MAX_USERS];
int user_count = 0;
int current_user_idx = -1;
void add_friends() {
    clear_input_buffer(); 
    printf("Enter usernames to add (in one line separated by space): ");
    char line[256];
    fgets(line, sizeof(line), stdin);
    line[strcspn(line, "\n")] = 0;

    char *token = strtok(line, " ");
    while (token != NULL) {
        User *me = &users[current_user_idx];
        
        if (strcmp(token, me->name) == 0) {
            printf("You cannot send a friend request to yourself.\n");
        } 
        else {
            int target_idx = find_user_index(token);
            if (target_idx == -1) {
                printf("Account %s does not exist.\n", token);
            } 
            else {
                User *target = &users[target_idx];
                
                // Check if already friends
                int is_friend = 0;
                for(int i=0; i<me->friend_count; i++) 
                    if(strcmp(me->friend_list[i], token) == 0) is_friend = 1;

                // Check if I already sent a request
                int sent_req = 0;
                for(int i=0; i<me->sent_count; i++)
                    if(strcmp(me->sent_requests[i], token) == 0) sent_req = 1;

                // Check if they already sent ME a request
                int received_req = 0;
                for(int i=0; i<me->waiting_count; i++)
                    if(strcmp(me->waiting_list[i], token) == 0) received_req = 1;

                if (is_friend) {
                    printf("You are already friends with %s.\n", token);
                } 
                else if (sent_req) {
                    printf("Friend request to %s is already pending.\n", token);
                } 
                else if (received_req) {
                    printf("%s has sent friend request to you.\n", token);
                } 
                else {
                    // Send request
                    strcpy(target->waiting_list[target->waiting_count++], me->name);
                    strcpy(me->sent_requests[me->sent_count++], token);
                    save_users();
                    printf("Friend request sent to %s.\n", token);
                }
            }
        }
        token = strtok(NULL, " ");
    }
}

void accept_friends() {
    User *me = &users[current_user_idx];
    if (me->waiting_count == 0) {
        printf("No pending friend requests for %s.\n", me->name);
        return;
    }

    printf("Pending friend requests for %s:\n", me->name);
    for(int i=0; i<me->waiting_count; i++) {
        printf("%d. %s\n", i+1, me->waiting_list[i]);
    }
    int opt_all = me->waiting_count + 1;
    int opt_back = me->waiting_count + 2;
    printf("%d. All\n", opt_all);
    printf("%d. Back\n", opt_back);
    
    printf("Enter indices (space separated), press Enter to finish: ");
    clear_input_buffer();
    char line[256];
    fgets(line, sizeof(line), stdin);
    
    // Logic to parse space separated indices
    int indices[MAX_FRIENDS];
    int count = 0;
    char *token = strtok(line, " ");
    while(token) {
        indices[count++] = atoi(token);
        token = strtok(NULL, " ");
    }

    int updated_any = 0;
    int accepted_all = 0;

    for(int k=0; k<count; k++) {
        int choice = indices[k];
        if (choice == opt_back) return;
        if (choice == opt_all) {
            accepted_all = 1;
            // Accept everyone
            for(int i=0; i<me->waiting_count; i++) {
                char *friend_name = me->waiting_list[i];
                int f_idx = find_user_index(friend_name);
                
                // Add mutual friends
                strcpy(me->friend_list[me->friend_count++], friend_name);
                strcpy(users[f_idx].friend_list[users[f_idx].friend_count++], me->name);
                
                // Remove from my sent requests (if logic requires, strictly request list clean up)
                // Remove from their sent requests
                for(int j=0; j<users[f_idx].sent_count; j++){
                    if(strcmp(users[f_idx].sent_requests[j], me->name)==0){
                        // shift delete
                        for(int m=j; m<users[f_idx].sent_count-1; m++) 
                             strcpy(users[f_idx].sent_requests[m], users[f_idx].sent_requests[m+1]);
                        users[f_idx].sent_count--;
                        break;
                    }
                }
            }
            me->waiting_count = 0;
            save_users();
            printf("Friend requests updated for all.\n");// [cite: 53]
            return; 
        }
    }

    // Process individual indices if 'All' wasn't selected
    // Note: The sample output shows sequential updates line by line.
    // We need to process carefully to avoid index shifting issues if we delete immediately.
    // Actually, simplest is to mark for acceptance then process.
    int to_accept[MAX_FRIENDS] = {0}; 
    
    for(int k=0; k<count; k++) {
        int idx = indices[k] - 1;
        if (idx >= 0 && idx < me->waiting_count) {
            to_accept[idx] = 1;
        }
    }

    // Since deleting shifts indices, we rebuild the waiting list
    char new_waiting[MAX_FRIENDS][NAME_LEN];
    int new_waiting_count = 0;
    
    for(int i=0; i<me->waiting_count; i++) {
        if (to_accept[i]) {
            char *friend_name = me->waiting_list[i];
            int f_idx = find_user_index(friend_name);
            
            strcpy(me->friend_list[me->friend_count++], friend_name);
            strcpy(users[f_idx].friend_list[users[f_idx].friend_count++], me->name);
            
            // Clean up their sent list
             for(int j=0; j<users[f_idx].sent_count; j++){
                if(strcmp(users[f_idx].sent_requests[j], me->name)==0){
                    for(int m=j; m<users[f_idx].sent_count-1; m++) 
                            strcpy(users[f_idx].sent_requests[m], users[f_idx].sent_requests[m+1]);
                    users[f_idx].sent_count--;
                    break;
                }
            }
            printf("Friend requests updated for %s.\n", friend_name);// [cite: 48]
        } 
        else {
            strcpy(new_waiting[new_waiting_count++], me->waiting_list[i]);
        }
    }
    
    // Update waiting list
    memcpy(me->waiting_list, new_waiting, sizeof(me->waiting_list));
    me->waiting_count = new_waiting_count;
    save_users();
}

void delete_friends() {
    User *me = &users[current_user_idx];
    if (me->friend_count == 0) {
        printf("You have no friends.\n");
        return;
    }

    printf("Your friends:\n");
    for(int i=0; i<me->friend_count; i++) {
        printf("%d. %s\n", i+1, me->friend_list[i]);
    }
    int opt_all = me->friend_count + 1;
    int opt_back = me->friend_count + 2;
    printf("%d. All\n", opt_all);
    printf("%d. Back\n", opt_back);
    
    printf("Enter friend numbers (separated by space), press Enter to finish: ");
    clear_input_buffer();
    char line[256];
    fgets(line, sizeof(line), stdin);

    int indices[MAX_FRIENDS];
    int count = 0;
    char *token = strtok(line, " ");
    while(token) {
        indices[count++] = atoi(token);
        token = strtok(NULL, " ");
    }

    for(int k=0; k<count; k++) {
        if(indices[k] == opt_back) return;
        if(indices[k] == opt_all) {
            printf("Deleting all...\n");// [cite: 65]
             for(int i=0; i<me->friend_count; i++) {
                int f_idx = find_user_index(me->friend_list[i]);
                // Remove me from them
                for(int j=0; j<users[f_idx].friend_count; j++) {
                    if(strcmp(users[f_idx].friend_list[j], me->name)==0) {
                        for(int m=j; m<users[f_idx].friend_count-1; m++) 
                            strcpy(users[f_idx].friend_list[m], users[f_idx].friend_list[m+1]);
                        users[f_idx].friend_count--;
                        break;
                    }
                }
            }
            me->friend_count = 0;
            printf("Friend list updated.\n");
            save_users();
            return;
        }
    }

    // Specific deletion
    int to_delete[MAX_FRIENDS] = {0};
    for(int k=0; k<count; k++) {
        int idx = indices[k] - 1;
        if(idx >= 0 && idx < me->friend_count) to_delete[idx] = 1;
    }

    char new_friends[MAX_FRIENDS][NAME_LEN];
    int new_cnt = 0;

    for(int i=0; i<me->friend_count; i++) {
        if(to_delete[i]) {
            printf("Deleting %s...\n", me->friend_list[i]);
            int f_idx = find_user_index(me->friend_list[i]);
            // Remove me from them
            for(int j=0; j<users[f_idx].friend_count; j++) {
                if(strcmp(users[f_idx].friend_list[j], me->name)==0) {
                    for(int m=j; m<users[f_idx].friend_count-1; m++) 
                        strcpy(users[f_idx].friend_list[m], users[f_idx].friend_list[m+1]);
                    users[f_idx].friend_count--;
                    break;
                }
            }
        }
        else {
            strcpy(new_friends[new_cnt++], me->friend_list[i]);
        }
    }
    memcpy(me->friend_list, new_friends, sizeof(me->friend_list));
    me->friend_count = new_cnt;
    printf("Friend list updated.\n");
    save_users();
}

void show_friends() {
    User *me = &users[current_user_idx];
    if (me->friend_count == 0) {
        printf("You have no friends.\n");
    } 
    else {
        printf("Your friends:\n");
        for(int i=0; i<me->friend_count; i++) {
            printf("%d. %s\n", i+1, me->friend_list[i]);
        }
    }
}